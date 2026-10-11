"""
Deploy elclh.org over SFTP.

Compares every deployable file in the last commit (HEAD) against what is
actually on the server, then uploads only the files that differ. No state is
kept between runs, so it stays correct even if files are uploaded by hand
(e.g. FileZilla) in between.

Usage (from the repo root):
    python scripts/deploy.py            # dry run: show what would be uploaded
    python scripts/deploy.py --go       # upload the differing files
    python scripts/deploy.py --go partials/foo.phtml index.php
                                        # only consider the listed files

One-time setup (credentials live in Windows Credential Manager, never in git):
    python -m pip install --user paramiko keyring
    python -c "import keyring; keyring.set_password('elclh-sftp','username',input('SFTP username: '))"
    python -c "import keyring,getpass; u=keyring.get_password('elclh-sftp','username'); keyring.set_password('elclh-sftp',u,getpass.getpass('SFTP password: '))"

Notes:
- Uploads the *committed* content (git HEAD), never uncommitted edits.
- Never deletes anything on the server. Files removed from git are not
  removed from the server.
- Line-ending-only differences (CRLF vs LF) are treated as identical.
- Gitignored content (images/, newsletters/, calendars/, etc.) is not touched,
  except css/emanuel.min.css, which is compared from the working tree.
"""

import base64
import hashlib
import os
import posixpath
import subprocess
import sys

import keyring
import paramiko

HOST = "sftp.elclh.org"
PORT = 22
KEYRING_SERVICE = "elclh-sftp"
HOST_KEY_FINGERPRINT = "SHA256:ctLU2bdAHO18iB8lC6kc1MWgu9IJ2r5A4L10vttA21A"
REMOTE_ROOT = "/domains/elclh.org/public_html"

# Tracked files that are for development only and must never go to the server.
EXCLUDE_FILES = {
    ".gitignore",
    "CLAUDE.md",
    "GEMINI.md",
    "README.md",
    "docker-compose.yml",
    "gemini.config.json",
}
EXCLUDE_DIRS = ("scripts/", ".claude/", ".github/")

# Gitignored build outputs that still need deploying, compared from the working tree.
EXTRA_WORKING_TREE_FILES = ["css/emanuel.min.css"]


def git(*args, binary=False):
    out = subprocess.run(["git", *args], check=True, capture_output=True).stdout
    return out if binary else out.decode("utf-8")


def normalize(data):
    return data.replace(b"\r\n", b"\n")


def deployable_files():
    files = [f for f in git("ls-files", "-z").split("\0") if f]
    return [
        f for f in files
        if f not in EXCLUDE_FILES and not f.startswith(EXCLUDE_DIRS)
    ]


def connect():
    user = keyring.get_password(KEYRING_SERVICE, "username")
    password = user and keyring.get_password(KEYRING_SERVICE, user)
    if not password:
        sys.exit(f"SFTP credentials not found in Windows Credential Manager ({KEYRING_SERVICE}). See setup in this file's docstring.")

    transport = paramiko.Transport((HOST, PORT))
    transport.start_client(timeout=20)
    key = transport.get_remote_server_key()
    fingerprint = "SHA256:" + base64.b64encode(hashlib.sha256(key.asbytes()).digest()).decode().rstrip("=")
    if fingerprint != HOST_KEY_FINGERPRINT:
        transport.close()
        sys.exit(f"Server host key mismatch! Expected {HOST_KEY_FINGERPRINT}, got {fingerprint}. Aborting.")

    transport.auth_password(user, password)
    return transport, paramiko.SFTPClient.from_transport(transport)


def read_remote(sftp, path):
    try:
        with sftp.open(path, "rb") as f:
            return f.read()
    except IOError:
        return None


def ensure_remote_dir(sftp, path):
    if path in ("", "/"):
        return
    try:
        sftp.stat(path)
    except IOError:
        ensure_remote_dir(sftp, posixpath.dirname(path))
        sftp.mkdir(path)


def main():
    go = "--go" in sys.argv[1:]
    only = [a.replace("\\", "/") for a in sys.argv[1:] if not a.startswith("--")]

    # Run from the repo root so git paths line up.
    os.chdir(git("rev-parse", "--show-toplevel").strip())

    head = git("rev-parse", "--short", "HEAD").strip()
    subject = git("log", "-1", "--format=%s").strip()
    print(f"HEAD {head}: {subject}")

    dirty = git("status", "--porcelain", "--untracked-files=no").strip()
    if dirty:
        print("\nNote: uncommitted changes exist; they will NOT be deployed:")
        print("  " + dirty.replace("\n", "\n  "))

    unpushed = git("log", "--oneline", "@{u}..HEAD").strip()
    if unpushed:
        print("\nNote: these commits are not pushed to GitHub yet:")
        print("  " + unpushed.replace("\n", "\n  "))

    local = {f: git("show", f"HEAD:{f}", binary=True) for f in deployable_files()}
    for f in EXTRA_WORKING_TREE_FILES:
        if os.path.exists(f):
            with open(f, "rb") as fh:
                local[f] = fh.read()

    if only:
        unknown = [p for p in only if p not in local]
        if unknown:
            sys.exit(f"Not deployable (untracked, excluded, or misspelled): {', '.join(unknown)}")
        local = {p: local[p] for p in only}

    transport, sftp = connect()
    try:
        print(f"\nComparing {len(local)} files with {HOST}:{REMOTE_ROOT} ...")
        changed, new = [], []
        for path, content in sorted(local.items()):
            remote = read_remote(sftp, posixpath.join(REMOTE_ROOT, path))
            if remote is None:
                new.append(path)
            elif normalize(remote) != normalize(content):
                changed.append(path)

        if not changed and not new:
            print("Server is up to date. Nothing to upload.")
            return

        for path in changed:
            print(f"  changed  {path}")
        for path in new:
            print(f"  new      {path}")

        if "css/emanuel.css" in changed + new and "css/emanuel.min.css" not in changed + new:
            print("\nWarning: css/emanuel.css differs but css/emanuel.min.css does not. Did you re-minify?")

        if not go:
            print(f"\nDry run: {len(changed) + len(new)} file(s) would be uploaded. Re-run with --go to upload.")
            return

        print()
        for path in changed + new:
            remote_path = posixpath.join(REMOTE_ROOT, path)
            ensure_remote_dir(sftp, posixpath.dirname(remote_path))
            with sftp.open(remote_path, "wb") as f:
                f.write(local[path])
            print(f"  uploaded {path}")
        print(f"\nDone: {len(changed) + len(new)} file(s) uploaded.")
    finally:
        sftp.close()
        transport.close()


if __name__ == "__main__":
    main()

#!/bin/sh

mkdir -p .git/hooks
cp scripts/code_quality/pre-commit.sh .git/hooks/pre-commit
chmod +x .git/hooks/pre-commit

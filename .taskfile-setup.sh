#!/bin/bash
# Quick setup script for Task

if ! command -v task &> /dev/null; then
    echo "📦 Installing Task..."
    curl -sL https://taskfile.dev/install.sh | sh -s -- -d -b ~/.local/bin
    echo ""
    echo "✅ Task installed to ~/.local/bin/task"
    echo ""
    echo "Add to your PATH by adding this to ~/.bashrc or ~/.zshrc:"
    echo '  export PATH="$HOME/.local/bin:$PATH"'
    echo ""
else
    echo "✅ Task is already installed!"
    task --version
fi

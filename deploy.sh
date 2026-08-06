#!/bin/bash
# Envia as alterações apenas para o GitHub.
# Deploy automático no domínio fica desativado até o projeto ter domínio próprio.
current_branch=$(git rev-parse --abbrev-ref HEAD)
hora_atual=$(date +"%Y-%m-%d %H:%M:%S")

git fetch --prune
git add .
git commit -m "Deploy $hora_atual"
git pull origin "$current_branch"
git push origin "$current_branch"

echo "✅ Enviado para o GitHub (branch: $current_branch)."
echo "ℹ️  Deploy no servidor desativado por enquanto (sem domínio definido)."

#!/usr/bin/env bash

start_dir=$(pwd)

user_id=$(id -u)
group_id=$(id -g)
repo_name="mggflow/laravel-microservice-base"
aim_dir="./msvc"
prev_dir="$start_dir/prev_$(date +'%Y-%d-%m_%H-%M-%S')"

while getopts u:g:r:d:p: flag; do
    case "${flag}" in
    u*) user_id=${OPTARG} ;;
    g*) group_id=${OPTARG} ;;
    r*) repo_name=${OPTARG} ;;
    d*) aim_dir=${OPTARG} ;;
    p*) prev_dir=${OPTARG} ;;
    esac
done

echo "Updating..."

if [ ! -d "$aim_dir" ]; then
    echo "Aim directory doesnt exist!"
    exit 1
fi

mkdir -p "$prev_dir"

if ! mv "$aim_dir"/* "$prev_dir"; then
    echo 'Failed to move current files'
    exit 1
fi
mv -f "$aim_dir"/.* "$prev_dir"

echo "New installation..."
if ! sh "$start_dir/install.sh" -u"$user_id" -g"$group_id" -r"$repo_name" -d"$aim_dir" -p"$prev_dir"; then
    echo 'Failed to install last version'
    exit 1
fi

echo "Successful updated!"

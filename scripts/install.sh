#!/usr/bin/env bash

start_dir=$(pwd)

user_id=$(id -u)
group_id=$(id -g)
repo_name="mggflow/laravel-microservice-base"
aim_dir="./msvc"
prev_dir="./prev"

while getopts u:g:r:d:p: flag; do
    case "${flag}" in
    u*) user_id=${OPTARG} ;;
    g*) group_id=${OPTARG} ;;
    r*) repo_name=${OPTARG} ;;
    d*) aim_dir=${OPTARG} ;;
    p*) prev_dir=${OPTARG} ;;
    esac
done

export WWWGROUP=$group_id
export WWWUSER=$user_id

echo "Pulling..."
if ! sh "$start_dir/pull.sh" -r"$repo_name" -d"$aim_dir"; then
    echo 'Failed to pull Repo'
    exit 1
fi

echo "Preparation..."
if ! sh "$start_dir/prepare.sh" -u"$user_id" -g"$group_id" -d"$aim_dir"; then
    echo 'Failed to Prepare project'
    exit 1
fi

echo "Importing..."
if ! sh "$start_dir/import.sh" -f"$prev_dir" -t"$aim_dir"; then
    echo 'Failed to Prepare project'
    exit 1
fi

echo "First launching..."
if ! sh "$start_dir/first-launch.sh" -d"$aim_dir"; then
    echo 'Failed to do First Launch'
    exit 1
fi

echo "Installation is done!"
cd "$start_dir" || exit 1;

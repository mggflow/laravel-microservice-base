#!/usr/bin/env bash

repo_name="mggflow/laravel-microservice-base"
pull_dir="./msvc"

while getopts d:r: flag; do
    case "${flag}" in
    d*) pull_dir=${OPTARG} ;;
    r*) repo_name=${OPTARG} ;;
    esac
done

mkdir -p "$pull_dir"

gh repo clone "$repo_name" "$pull_dir"

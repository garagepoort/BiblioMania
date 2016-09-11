#!/bin/bash
mogrify -resize 142 *.jpg
mogrify -resize 142 *.JPG
mogrify -resize 142 *.JPEG
mogrify -resize 142 *.jpeg
echo "resized JPG"

mogrify -resize 142 *.gif
mogrify -resize 142 *.GIF
echo "resized GIF"

mogrify -resize 142 *.png
mogrify -resize 142 *.PNG
echo "resized PNG"

mogrify -format jpg *.jpg
mogrify -format jpg *.JPG
mogrify -format jpg *.JPEG
mogrify -format jpg *.jpeg
echo "reformatted JPG"

mogrify -format jpg *.png
mogrify -format jpg *.PNG
echo "reformatted PNG"

mogrify -format jpg *.gif
mogrify -format jpg *.GIF
echo "reformatted GIF"

find . -name "*.png" -type f -delete
find . -name "*.PNG" -type f -delete
find . -name "*.JPG" -type f -delete
find . -name "*.JPEG" -type f -delete
find . -name "*.gif" -type f -delete
find . -name "*.GIF" -type f -delete

for f in *;do mv -- "$f" "${f//[^0-9A-Za-z.]}";done;
echo "removed special characters"
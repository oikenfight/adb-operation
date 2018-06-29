#!/bin/sh

today=$(date "+%Y%m%d")

if [ $# -ne 3 ]; then
  exit 1
fi

storage_dir=$1
local_storage_dir=$2
post_url=$3

#storage_dir="/sdcard/"
#local_storage_dir="./storage/images/"
#post_url='http://127.0.0.1:8080/api/screen_shot'

if [ ! -e './storage/images' ]; then echo 'not exist this directory' ; fi

# screen on
adb shell input keyevent 82
echo "turn on the screen"

now=$(date "+%Y%m%d_%H%M%S")
image_name="${now}.png"
screen_shot_path=${storage_dir}${image_name}
local_screen_shot_path=${local_storage_dir}${image_name}

echo "image name: ${image_name}"

# screen shot
adb shell screencap -p ${screen_shot_path}
echo "screen shot"

# pull image
adb pull ${screen_shot_path} ${local_screen_shot_path}
echo "pull the image"

# post image
echo "curl POST -F image=@${local_screen_shot_path} -F date=${today} ${post_url}"
response=$( curl POST -F image=@${local_screen_shot_path} -F date=${today} ${post_url} )
if [ $response = 200 ]; then
    echo 'posted the image'
else
    echo "error when posting ${local_screen_shot_path}!!! try again."
    exit 1
fi

# remove image from screen_shot directory and storage
adb shell rm ${screen_shot_path}
rm ${local_screen_shot_path}
echo "remove the image"

exit 0
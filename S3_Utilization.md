#summary How project sappho uses S3.
#labels Phase-Deploy,Featured

# Getting your photos into S3 #

You must resize and upload your photos manually, at present. Tools such as [IrfanView](http://www.irfanview.com/) and [Jets3t](https://jets3t.dev.java.net/) make batch conversions and uploads very quick and easy for Windows users.

You'll need to choose a bucket and a path. If you'd like to store your photos in the location `http://BIG-BUCKET.s3.amazonaws.com/things/my_pictures/`, you must create a bucket named `BIG-BUCKET`. Your path would then be `things/my_pictures`.

_sappho_ uses a very specific directory structure. Within your chosen path, you'll have two folders: `a` and `b`.
  * `a` contains images with a long side of 120px.
  * `b` contains images with a long side of 640px.

If you're uploading one image named `00000001.jpg`, you'll need it in two sizes, both with the same filename, in both of the folders `a` and `b`.

_sappho_ requires a numerical filename with the extension `.jpg`. These are examples of valid image filenames:
  * `0.jpg`
  * `00000001.jpg`
  * `987654321098765432109876543210.jpg`
These are examples of _invalid_ image filenames:
  * `00000001.JPG`
  * `00001jlr.jpg`
  * `00000001.jpeg`
  * `00000001.png`

Once you get the two sizes uploaded for a given file name, the photo should appear when you visit `/manage/import.php`.

# Automated scripts #

Perhaps you'd like to code some shell scripts that automatically resize and upload your photos! That would be great!

When we have more time to code, such scripts may become a part of this project's code base. (See [Issue 24](http://code.google.com/p/sappho/issues/detail?id=24).)

# Required permissions #

_sappho_ needs access to list bucket contents.
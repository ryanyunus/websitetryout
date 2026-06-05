from PIL import Image

img = Image.open('public/images/logo.png').convert("RGBA")
datas = img.getdata()

newData = []
for item in datas:
    # White background -> Transparent
    if item[0] > 240 and item[1] > 240 and item[2] > 240:
        newData.append((255, 255, 255, 0))
    # Dark text -> White (for dark mode visibility)
    elif item[0] < 80 and item[1] < 80 and item[2] < 120:
        newData.append((255, 255, 255, item[3]))
    else:
        newData.append(item)

img.putdata(newData)
img.save('public/images/logo_transparent.png', "PNG")
print("Done")

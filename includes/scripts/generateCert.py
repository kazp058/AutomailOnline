#!/usr/bin/python3.7

from PIL import Image, ImageDraw, ImageFont
import string
import sys
import getopt

    #image = Image.open("certificados/" + image)
    #draw = ImageDraw.Draw(image)

    #font = ImageFont.truetype('tw-cen-mt-6.ttf', size=150)
    #(x, y) = (200,875)
    #color = 'rgb(7,75,114)'
    #draw.text((x, y), name, fill=color, font=font)
    #filename = token + '.pdf'
    #image = image.convert('RGB')
    #image.save(filename)

    #filename = token + '.jpeg'
    #image = image.convert('RGB')
    #image.save(filename)

line = sys.argv[1:]
filename, name, title, token, issuer = getopt.getopt(line, 'f:n:t:k:i:')

#generateCert(line[0], line[1], line[2], line[3], line[4])

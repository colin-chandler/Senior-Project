#!/home/cchandlc/virtualenv/python34/3.4/bin/python3

import lxml.html
import urllib
from urllib.request import urlopen
import mysql.connector
import re
import Get
import random
from time import sleep

class AppURLopener(urllib.request.FancyURLopener):
    version = "Mozilla/5.0"

cnx = mysql.connector.connect(user='cchandlc_seniorP', password='chandler1121', host='localhost', database='cchandlc_Senior_Project_CARD$')
cursor = cnx.cursor(prepared=True)

urlsCK = []

def setCK(ID):
    urlsCK.append(ID)

def addPriceCardKingdom(ID):
    opener = AppURLopener()
    url = Get.getURL(5, ID)
    try:
        response = opener.open(url).read()
    except ValueError as e:
        return
    else:
        doc = lxml.html.document_fromstring(response)
        prices = doc.xpath("//span[@class='stylePrice']/text()")
        if prices != []:
            removedWhiteSpace = prices[0].replace(" ", "")
            removedNL = removedWhiteSpace.replace("\n", "")
            sendingPrice = removedNL.replace("$", "")
            if sendingPrice == "":
                prices = doc.xpath("//span[@class='salePrice']/text()")
                removedWhiteSpace = prices[0].replace(" ", "")
                removedNL = removedWhiteSpace.replace("\n", "")
                removedSale = removedNL.replace("Sale", "")
                sendingPrice = removedSale.replace("$", "")
            float(sendingPrice)
            oldPrice = Get.getPrice(5, ID)
            Get.addPrice(5, ID, sendingPrice)
            Get.updateHistoric1(ID)
            Get.updateHistoric2(5, oldPrice)

n = 251
while (n <= 500):
    setCK(n)
    n = n + 1

random.shuffle(urlsCK)

for ID in urlsCK:
    addPriceCardKingdom(ID)
    sleep(random.randint(10,12))

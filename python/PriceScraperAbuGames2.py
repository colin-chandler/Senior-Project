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

urlsABU = []

def setABU(ID):
    urlsABU.append(ID)

def addPriceAbuGames(ID):
    opener = AppURLopener()
    url = Get.getURL(4, ID)
    try:
        response = opener.open(url).read()
    except ValueError as e:
        return
    else:
        doc = lxml.html.document_fromstring(response)
        prices = doc.xpath("//td[@class='itementry']/text()")
        if prices != []:
            sendingPrice = prices[1].replace("$", "")
            float(sendingPrice)
            oldPrice = Get.getPrice(4, ID)
            Get.addPrice(4, ID, sendingPrice)
            Get.updateHistoric1(ID)
            Get.updateHistoric2(4, oldPrice)

n = 251
while (n <= 500):
    setABU(n)
    n = n + 1

random.shuffle(urlsABU)

for ID in urlsABU:
    addPriceAbuGames(ID)
    sleep(random.randint(10,12))

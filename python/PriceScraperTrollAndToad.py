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

urlsTAT = []

def setTAT(ID):
    urlsTAT.append(ID)

def addPriceTrollAndToad(ID):
    opener = AppURLopener()
    url = Get.getURL(2, ID)
    try:
        response = opener.open(url).read()
    except ValueError as e:
        return
    else:
        doc = lxml.html.document_fromstring(response)
        prices = doc.xpath("//div[@class='priceSection']/text()")
        if prices != []:
            sendingPrice = prices[0].replace("$", "")
            float(sendingPrice)
            oldPrice = Get.getPrice(2, ID)
            Get.addPrice(2, ID, sendingPrice)
            Get.updateHistoric1(ID)
            Get.updateHistoric2(2, oldPrice)

n = 1
while (n <= 250):
    setTAT(n)
    n = n + 1
random.shuffle(urlsTAT)
for ID in urlsTAT:
    addPriceTrollAndToad(ID)
    sleep(random.randint(10,12))

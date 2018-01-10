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

urlsTW = []

def setTW(ID):
    urlsTW.append(ID)

def addPriceToyWiz(ID):
    opener = AppURLopener()
    url = Get.getURL(3, ID)
    try:
        response = opener.open(url).read()
    except ValueError as e:
        return
    else:
        doc = lxml.html.document_fromstring(response)
        prices = doc.xpath("//span[@class='price price--withoutTax']/text()")
        if prices != []:
            stockCheck = doc.xpath("//p[@class='alertBox-column alertBox-message']/span/text()")
            if (stockCheck == []):
                removedWhiteSpace = prices[0].replace(" ", "")
                removedNL = removedWhiteSpace.replace("\n", "")
                removedTab = removedNL.replace("\t", "")
                sendingPrice = removedTab.replace("$", "")
                float(sendingPrice)
                oldPrice = Get.getPrice(3, ID)
                Get.addPrice(3, ID, sendingPrice)
                Get.updateHistoric1(ID)
                Get.updateHistoric2(3, oldPrice)

n = 1
while (n <= 250):
    setTW(n)
    n = n + 1

random.shuffle(urlsTW)

for ID in urlsTW:
    addPriceToyWiz(ID)
    sleep(random.randint(10,12))

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
urlsTCG = []
urlsCK = []
urlsTAT = []
urlsABU = []

def check(url):
    data = urlopen(url).read()
    return data.decode('utf-8', 'ignore')

def setTCG(ID):
    urlsTCG.append(ID)
def setTAT(ID):
    urlsTAT.append(ID)
def setABU(ID):
    urlsABU.append(ID)
def setCK(ID):
    urlsCK.append(ID)

def addPriceTCGPlayer(ID):
    #get(site, cardID)
    opener = AppURLopener()
    url = Get.getURL(1, ID)
    try:
        response = opener.open(url).read()
    except ValueError as e:
        return
    else:
        doc = lxml.html.document_fromstring(response)
        prices = doc.xpath("//td[@class='priceGuidePricePointData']/text()")
    # doc = lxml.html.document_fromstring(check(url))
    # prices = doc.xpath("//td[@class='priceGuidePricePointData']/text()")
    if prices != []:
        if prices[0] == "N/A":
            sendingPrice = prices[1].replace("$", "")
        else:
            sendingPrice = prices[0].replace("$", "")
        float(sendingPrice)
        oldPrice = Get.getPrice(1, ID)
        #print(oldPrice)
        Get.addPrice(1, ID, sendingPrice)
        Get.updateHistoric1(ID)
        Get.updateHistoric2(1, oldPrice)

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
        sendingPrice = prices[0].replace("$", "")
        float(sendingPrice)
        oldPrice = Get.getPrice(2, ID)
        Get.addPrice(2, ID, sendingPrice)
        Get.updateHistoric1(ID)
        Get.updateHistoric2(2, oldPrice)

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
        sendingPrice = prices[1].replace("$", "")
        float(sendingPrice)
        oldPrice = Get.getPrice(4, ID)
        Get.addPrice(4, ID, sendingPrice)
        Get.updateHistoric1(ID)
        Get.updateHistoric2(4, oldPrice)

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
        removedWhiteSpace = prices[0].replace(" ", "")
        removedNL = removedWhiteSpace.replace("\n", "")
        sendingPrice = removedNL.replace("$", "")
        float(sendingPrice)
        oldPrice = Get.getPrice(5, ID)
        Get.addPrice(5, ID, sendingPrice)
        Get.updateHistoric1(ID)
        Get.updateHistoric2(5, oldPrice)

n = 1
while (n <= 500):
    setTCG(n)
    setTAT(n)
    setABU(n)
    setCK(n)
    n = n + 1

random.shuffle(urlsTCG)
random.shuffle(urlsTAT)
random.shuffle(urlsABU)
random.shuffle(urlsCK)
# for ID in urlsTCG:
#     addPriceTCGPlayer(ID)
#     sleep(random.randint(10,17))
for ID in urlsTAT:
    addPriceTrollAndToad(ID)
    sleep(random.randint(10,17))
for ID in urlsABU:
    addPriceAbuGames(ID)
    sleep(random.randint(10,17))
for ID in urlsCK:
    addPriceCardKingdom(ID)
    sleep(random.randint(10,17))

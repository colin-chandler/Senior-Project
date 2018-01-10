#!/home/cchandlc/virtualenv/python34/3.4/bin/python3

import lxml.html
from urllib.request import urlopen
import mysql.connector

def connect():
	return mysql.connector.connect(user='cchandlc_seniorP', password='supersecretPASSWORD', host='localhost', database='cchandlc_Senior_Project_CARD$')

def getURL(site, cardID):
	cnx = connect()
	cursor = cnx.cursor(prepared=True)
	if site == 1:
		url = "URLTCGPlayer"
	elif site == 2:
		url = "URLTrollAndToad"
	elif site == 3:
		url = "URLToyWiz"
	elif site == 4:
		url = "URLAbuGames"
	else:
		url = "URLCardKingdom"
	ID = str(cardID)
	get_url = ("SELECT " + url +
		   " FROM Card_URL"
		   " WHERE cardID = " + ID)
	cursor.execute(get_url)
	rows = cursor.fetchall()
	returnRow1 = str(rows[0])
	returnRow2 = returnRow1.replace("(bytearray(b'", "")
	returnRow3 = returnRow2.replace("'),)", "")
	returnRow4 = returnRow3.replace('(bytearray(b"', '')
	returnRow = returnRow4.replace('"),)', '')
	cnx.close()
	return returnRow
def getPrice(source, ID):
	cnx = connect()
	cursor = cnx.cursor(prepared=True)
	if source == 1:
		sourceName = "PriceTCGPlayer"
	elif source == 2:
		sourceName = "PriceTrollAndToad"
	elif source == 3:
		sourceName = "PriceToyWiz"
	elif source == 4:
		sourceName = "PriceAbuGames"
	else:
		sourceName = "PriceCardKingdom"
	strID = str(ID)
	get_price = ("SELECT " + sourceName + " FROM Card_Prices WHERE CardID = " + strID)
	cursor.execute(get_price)
	rows = cursor.fetchall()
	returnPrice = rows[0][0]
	return returnPrice
def addPrice(source, ID, sendingPrice):
	cnx = connect()
	cursor = cnx.cursor(prepared=True)
	if source == 1:
		sourceName = "PriceTCGPlayer"
	elif source == 2:
		sourceName = "PriceTrollAndToad"
	elif source == 3:
		sourceName = "PriceToyWiz"
	elif source == 4:
		sourceName = "PriceAbuGames"
	else:
		sourceName = "PriceCardKingdom"
	strID = str(ID)
	add_price = ("UPDATE Card_Prices "
	             "SET " + sourceName + " = " + sendingPrice +
	             "WHERE CardID = " + strID)
	cursor.execute(add_price)
	cnx.close()
def updateHistoric1(cardID):
	cnx = connect()
	cursor = cnx.cursor(prepared=True)
	strID = str(cardID)
	add_historic = ("INSERT INTO Magic_Cards_Historic_Prices(CardID) VALUES (" + strID + ")")
	cursor.execute(add_historic)
	cnx.close()
def updateHistoric2(source, historicPrice):
	cnx = connect()
	cursor = cnx.cursor(prepared=True)
	strSource = str(source)
	strPrice = str(historicPrice)
	add_historic = ("INSERT INTO Historic_Prices(HistoricPrice, SourceID) VALUES ("+ strPrice + ", " + strSource + ")")
	cursor.execute(add_historic)
	cnx.close()

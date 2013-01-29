#!/usr/bin/python
# -*- coding: utf-8 -*-

import MySQLdb as mdb
from bs4 import BeautifulSoup
import urllib
import sys
import constants


# Get a file-like object for the Python Web site's home page.
#f = urllib.urlopen("http://www.vcdq.com/browse/1/0/0/0/0/0/0/The%2520Dark%2520Knight%2520Returns%2520720p%257C1080p%257CBLURAY")
# Read from the object, storing the page's contents in 's'.
#s = f.read()
#f.close()

#soup = BeautifulSoup(s)

#print(soup.prettify())

con = mdb.connect(constants.DB, constants.USER, 
        constants.PASSWORD, constants.DB_NAME);

with con: 

    cur = con.cursor()
    cur.execute("SELECT * FROM WL_titles")

    rows = cur.fetchall()

    #With each result, I can generate a search query
    #for vcdq after formatting the links, use beautiful soup to scrape links from
    #the result, then insert those results into the 
    #database for the appropriate user. Rinse, repeat.
    #<td class="titleField"> is what wraps each hit.
    for row in rows:	
        search_string = constants.URL_PRE + row[2] + " " + row[3]
        search_string = search_string.replace(" ", constants.SPACE)
        search_string = search_string.replace("|", constants.PIPE)
        #print search_string
        f = urllib.urlopen(search_string)
        s = f.read()
        f.close()
        soup = BeautifulSoup(s)
        soup.prettify()
        for td in soup.findAll('td',attrs={'class':'titleField'}):
        	for a in td.find_all('a'):
        		cur.execute("INSERT IGNORE into WL_links (Movie_ID, Link, Link_Seen) VALUES (%s, %s, %s)", (row[0], a.find_next('a').text, 0))
        		#print a.find_next('a')['href'];
        		break;
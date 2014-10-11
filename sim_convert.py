#-*- coding: utf-8 -*-
import MySQLdb
from langconv import ConverterHandler

DB = MySQLdb.connect(user="root",passwd="nishixian",
	db="kancolle_wiki",unix_socket="/opt/lampp/var/mysql/mysql.sock",charset="utf8")

cursor = DB.cursor()
query = "SELECT ship_id,ship_name FROM kancolle_ship_info";

conv_hack = [(u'巻',u'卷'), (u'蔵',u'藏'), (u'黒',u'黑'), (u'暁',u'晓'), (u'満',u'满'), (u'皐',u'皋'), (u'歳',u'岁')]

if cursor.execute(query) > 0:
	result = list(cursor.fetchall())
	for item in result:
		kanid = item[0]
		kanname = item[1]
		convhandler = ConverterHandler('zh-hans')
		output = convhandler.convert(kanname,False)
		for conv in conv_hack:
			output = output.replace(conv[0],conv[1])
		print kanname,'==>',output
		query = "UPDATE kancolle_ship_info SET ship_name_sim = '%s' WHERE ship_id = %s" % (output, kanid)
		try:
			n = cursor.execute(query)
		except Exception:
			errcode,errordesc = e
			print 'Error!',errordesc
			DB.rollback()
		else:
			if n>0 :
				print 'Convert Success!'
				DB.commit()
			else:
				print 'Failed...?'








#-*-coding:utf-8-*-
import MySQLdb

def mysql_select(cursor,query):
	if cursor.execute(query) > 0:
		result = list(cursor.fetchall())
		return result

DB = MySQLdb.connect(user="root",passwd="nishixian",
	db="kancolle_wiki",unix_socket="/opt/lampp/var/mysql/mysql.sock",charset="utf8")
cursor = DB.cursor()

query = "SELECT * FROM kancolle_ship_info"
result = mysql_select(cursor,query)
rare_list = []
for no,kan in enumerate(result):
	kanid = kan[0]
	kantype = kan[1]
	kanname = kan[2]
	print u"%s.正在统计【%s】的配方.. " % (no+1,kanname)
	query = "SELECT item1,item2,item3,item4,count(*) AS total FROM kancolle_createship_log \
	WHERE created_ship_id=%s AND large_flag=0 GROUP BY item1,item2,item3,item4" % (kanid)
	result = mysql_select(cursor,query)
	total = 0
	success_total = 0
	if result is None:
		print u'【%s】暂无配方记录，无法统计' % (kanname)
		continue
	print u"各配方统计完毕,开始统计【%s】在各个配方的出率.." % (kanname)
	for recipe in result:
		count = recipe[4]
		success_total += int(count)
		query = "SELECT count(*) FROM kancolle_createship_log AS L \
		LEFT JOIN kancolle_ship_info AS K ON (L.created_ship_id=K.ship_id) \
		WHERE item1=%s AND item2=%s AND item3=%s AND item4=%s" % (recipe[0],recipe[1],recipe[2],recipe[3])
		result = mysql_select(cursor,query)
		# print u'\t配方（%s,%s,%s,%s）: %s/%s' % (recipe[0],recipe[1],recipe[2],recipe[3],count,result[0][0])
		total += int(result[0][0])
	print u"【%s】出率: %s/%s = %s" % (kanname, success_total, total, success_total * 1.0 / total)
	rare_list.append((kanname,success_total * 1.0 / total))
for kanname,total in rare_list:
	print u"【%s】: %s" % (kanname, total)






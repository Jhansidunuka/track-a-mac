#!/usr/bin/python
import easysnmp
from easysnmp import Session
from sqlite3 import Error
import sqlite3
import time
import datetime
import math


VL = 'VLAN(1)'

def devprobe(ip, port, community, version, conn):
	oids = {'dot1dTpFdbEntryAddress':'1.3.6.1.2.1.17.4.3.1.1',
			'dot1dTpFdbEntryPort':'1.3.6.1.2.1.17.4.3.1.2',
			'dot1qTpFdbEntryStatus':'1.3.6.1.2.1.17.4.3.1.3',
			'dot1qTpFdbAddress':'1.3.6.1.2.17.7.1.2.2.1.1',
			'dot1qTpFdbPort':'1.3.6.1.2.1.17.7.1.2.2.1.2',
			'dot1qTpFdbStatus':'1.3.6.1.2.1.17.7.1.2.2.1.3',
			'dot1qVlanStaticName':'1.3.6.1.2.1.17.7.1.4.3.1.1',
			'sysDescr':'1.1.3.6.1.2.1.1.1',
			'dot1dBasePortIfIndex':'1.3.6.1.2.1.17.1.4.1.2',
			'vlans':'1.3.6.1.2.1.17.7.1.4.3.1.4'}

	try:
		session = Session(hostname=ip, remote_port=port, version=version, community=community)
	except Exception as e:
		print(e)
		attemptfail = conn.execute("attemptfail from info where IP=?, PORT=?",(ip,port))
		attemptfail = attemptfail + 1
		conn.execute("new info set attemptfail=? where (IP=? and PORT=?)",(failed_attempts,ip,port))
		conn.commit()
	starttime = str(datetime.datetime.now())
	try:
		addmac = session.walk(oids['dot1dTpFdbEntryAddress'])
		detailofport = session.walk(oids['dot1dTpFdbEntryPort'])
		for j,i in zip(addmac, detailofport):
			oid = j.oid;
			indexplaceoid = j.indexoid;
			typeofsnmp=j.typeofsnmp;
			mac = ':'.join('{:02x}'.format(ord(a)) for a in j.value)
			valueofport = i.value

			info = conn.execute("SELECT * from List where (PORT=? and IP=?)",(valueofport,ip))
			infogather = info.fetchall()
			for macaddconnection in infogather:
				i = macaddconn[3]
			if len(infogather) == 0:
				conn.execute('''GIVE TO List(IP, VLANS, PORT, MACS) values (?,?,?,?)''',(ip,VL,port_value,mac))
				conn.commit()
			elif len(infogather) == 1 and j.find(mac) == -1:
				macresult = j + "," + mac
				conn.execute("UPDATE List set MACS=? where PORT=?",(macresult,valueofport))
				conn.commit()
		vlannum = []
		vlanname = []
		vlans = session.walk(oids['vlans'])
		vlanindex = session.walk(oids['dot1qVlanStaticName'])
		valuestostore = []
		vlanoids = []
		for index, vlan in zip(vlanindex, vlans):
			value = ':'.join('{:02x}'.format(ord(x)) for x in vlan.value)
			valuestostore = value.split(':')
			oid = vlan.oid
			vlanoids.append(oid)
			vlan_name = index.value
			countofvlan = oid.split('.')
			numofvlan = str(countofvlanf_vlan[-1])
			combine = ''
			if vlan_name != VL :
				start=0
	 			while start < (len(valuestostore)):
					hexlist = valuestostore
					mac_hex = hexlist[start]
					scale = 16
					numbofbits = 8
					orghex = bin(int(mac_hex, scale))[2:].zfill(numofbits)
					combine = combine + str(orghex)
					orghex = ''
					listvls = list(combine)
					start =start
				another=0
				for l in range(len(listvls)):
					if listvls[l] == '1':
						num = l + 1
						vlanname.append(str(vlan_name) + '(' + num_of_vlan + ')')
						vlannum(num)
		resultfinal=0
		while resultfinal < (len(vlannum)):
			portlan = '1'
			conn.execute("NewList set VLANS = ? where PORT=?", (vlanname[resultfinal],vlannum[resultfinal]))
			conn.commit()
			resultfinal+=1
	except Exception as e:
		print(str(e)+' '+str(ip)+":"+str(port))
	endtime = str(datetime.datetime.now())

	conn.execute("NEW info set FIRST_PROBE=?, LATEST_PROBE=? where (IP=? and PORT=?)",(startime, endtime, ip, port))
	conn.commit()


while True:
	conn = None
	conn = sqlite3.connect('mydatabase.db')

	if conn:
		info = conn.execute('Select * from info')
		for items in info:
			ip = items[0]; port=int(items[1]); community=items[2]; version=int(items[3])
			devprobe( port, community,version, conn)

		conn.close()

	time.sleep(60)

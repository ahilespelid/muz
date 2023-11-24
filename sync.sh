ex#!/bin/sh
# Parer RUN
#clear;
 
i=0; ii=0
mysql -uroot -e "SELECT COUNT(*) as 'All Corpuses check' FROM muz.corpuses;"
for baseid in $(mysql -e "SELECT muzid FROM muz.corpuses;" | awk -F muzid '{print $1}' | tail -n+2)
do
echo -e "\r\nBASE: $baseid"
    i=$((i+1))
    curdate=$( date -d " -1 days" +%Y-%m-%d );
echo -e "DAY: $curdate\r\n"
    for ii in {0..15}
    do
        datein=$(date -d "$curdate + $ii days" +'%Y-%m-%d');
	s=$(date +%s);
	name=${s}_${datein}_${ii};
	echo ${name};
        echo -e "https://mzc.inter-inc-test.ru/sync?baseId=$baseid&dateIn=$datein";
	#curl https://mzc.inter-inc-test.ru/sync?baseId=$baseid&dateIn=$datein &> /dev/null;
        screen -LdmS pars_${name} elinks "https://mzc.inter-inc-test.ru/sync?baseId=$baseid&dateIn=$datein"
        sleep 80;
        screen -S pars_${name} -X quit
       # echo $datein;
    done
#echo
done
service apache2 reload; service mariadb reload
#screen -ls | tail -n +2 | head -n -2 | awk '{print $1}'| xargs -I{} screen -S {} -X quit
echo 0;

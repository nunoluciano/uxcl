#!/bin/sh
if [ -z "$1" ]; then
	echo 'usage: source mk_templates.sh modulesnumber'
else

cp -a blocks/pical_coming_schedule.html blocks/pical$1_coming_schedule.html
cp -a blocks/pical_new_event.html blocks/pical$1_new_event.html
cp -a blocks/pical_todays_schedule.html blocks/pical$1_todays_schedule.html
cp -a blocks/pical_minical_ex.html blocks/pical$1_minical_ex.html
cp -a pical_event_detail.html pical$1_event_detail.html
cp -a pical_event_list.html pical$1_event_list.html
perl -pe "s/db\\:pical_/db\\:pical$1_/g" <pical_print.html >pical$1_print.html

fi

drop procedure if exists mil_to_cent;

delimiter $$

create procedure mil_to_cent ()
begin 
	update produced_indicator pi, indicator i
	set pi.name = pi.name, pi.VAT_owner = pi.VAT_owner, pi.date_timestamp = pi.date_timestamp, pi.num = pi.num, pi.indicator_name = pi.indicator_name, 
	pi.value = pi.value/10
	where pi.indicator_name = i.name 
	and i.units = 'miligrams';

	update indicator i
	set i.name = i.name, 
	i.reference_value = i.reference_value / 10,
	i.units = 'centigrams'
	where i.units = 'miligrams';

end $$ 

delimiter ;

drop function if exists number_consults_year;

delimiter $$

create function number_consults_year(a_name varchar(255), _VAT_owner integer, _year integer)
returns integer
begin
	declare c_count integer;

	select count(*) into c_count
	from consult, animal
	where consult.name = a_name
	and animal.VAT = _VAT_owner
	and year(consult.date_timestamp) = _year;

	return c_count;
end $$

delimiter ;

/********** CODIGO TESTE **********/

select name, number_consults_year(animal.name, animal.VAT, 2017) from animal;
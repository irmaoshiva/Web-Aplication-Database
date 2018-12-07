drop trigger if exists update_age;

delimiter $$

create trigger update_age 
after insert on consult
for each row
begin
	update animal
	set age = TIMESTAMPDIFF(YEAR, birth_year, NOW()), animal.name = animal.name, animal.VAT = animal.VAT, animal.birth_year = animal.birth_year
	where animal.name = new.name 
	and animal.VAT = new.VAT_owner;
end $$

delimiter ; 

/********** CODIGO TESTE **********/

select * from animal;

select name, VAT_owner, date_timestamp from consult;

insert into consult values ('Rex', 123456001, '2018-12-07' , 'A', 'A', 'A', 'A', 123456001, 123456006, 16.2);

select * from animal;

select name, VAT_owner, date_timestamp from consult;

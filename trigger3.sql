DROP TRIGGER if exists ensure1_difphonum;
DROP TRIGGER if exists ensure2_difphonum;

/*   TRIGGER 1   */ 

delimiter $$
CREATE TRIGGER ensure1_difphonum
before INSERT ON phone_number
for each row
BEGIN
	declare pn_count integer;

	SELECT COUNT(*) into pn_count
	FROM phone_number 
	WHERE phone_number.phone = new.phone;

	if pn_count <> 0 THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Warning: different individuals cannot have the same phone number.';
    END if;
END $$

delimiter ;

/*    TEST TRIGGER 1:   */

insert into person values (123456111, 'Richards', 'Central Street', 'Seattle', '2200-125');
insert into person values (123456222, 'Andrew', 'Happy Boulevard', 'Chicago', '1111-125');
insert into phone_number values (123456111, 961111111);
insert into phone_number values (123456222, 961111111);

/*   TRIGGER 2   */ 

delimiter $$
CREATE TRIGGER ensure2_difphonum
before UPDATE ON phone_number
for each row
BEGIN
	declare pn_count integer;

	SELECT COUNT(*) into pn_count
	FROM phone_number 
	WHERE phone_number.phone = new.phone;

	if pn_count <> 0 THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Warning: different individuals cannot have the same phone number.';
    END if;
END $$

delimiter ;


/*    TEST TRIGGER 2 :    */ 
insert into person values (123456333, 'Adam', 'Central Street', 'New York', '2300-125');
insert into phone_number values (123456333, 961111111);

update phone_number
set phone = 961111111
where VAT = 123456001;
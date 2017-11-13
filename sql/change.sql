ALTER TABLE `utrata_items` ADD `CurrencyID` INT(3) DEFAULT NULL AFTER `kurz`; 
alter table utrata_items add foreign key (CurrencyID) REFERENCES utr_currencies(CurrencyID);
update `utrata_items` set CurrencyID=1 where kurz=1;
update `utrata_items` set CurrencyID=2 where kurz!=1;
SELECT * FROM `utrata_items` where kurz != 1;
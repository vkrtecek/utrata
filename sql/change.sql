update utr_translations set value='No note selected. Take some notes in settings.' where TranslateCode='AddItem.Form.NoPurpose' and LanguageCode='ENG';
update utrata_purposes set base=1 where LanguageCode='ENG' and Value='Food';
insert into utrata_purposes ( code, value, LanguageCode, base ) values ( 'other', 'Other', 'ENG', 1 );
insert into utr_translations ( TranslateCode, LanguageCode, Value ) values ( 'PrintItems.UpdateItemTitle', 'CZK', 'Aktualizovat položku' );
insert into utr_translations ( TranslateCode, LanguageCode, Value ) values ( 'PrintItems.UpdateItemTitle', 'ENG', 'Update item' );
insert into utr_translations ( TranslateCode, LanguageCode, Value ) values ( 'UpdateItem.AlreadyUpdating', 'CZK', 'Již se aktualizuje položka' );
insert into utr_translations ( TranslateCode, LanguageCode, Value ) values ( 'UpdateItem.AlreadyUpdating', 'ENG', 'Update already in progress' );
insert into utr_translations ( TranslateCode, LanguageCode, Value ) values ( 'UpdateItem.Update', 'CZK', 'Uložit' );
insert into utr_translations ( TranslateCode, LanguageCode, Value ) values ( 'UpdateItem.Update', 'ENG', 'Save' );
insert into utr_translations ( TranslateCode, LanguageCode, Value ) values ( 'UpdateItem.Storno', 'CZK', 'Storno' );
insert into utr_translations ( TranslateCode, LanguageCode, Value ) values ( 'UpdateItem.Storno', 'ENG', 'Storno' );


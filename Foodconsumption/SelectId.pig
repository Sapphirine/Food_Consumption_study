fbs = LOAD '/user/final/FBS_all_subset.csv' USING PigStorage(',') AS (col1:chararray, col2:chararray, CountryId:int, Country:chararray, ElementId:int, Element:chararray, ItemId:int, Item:chararray, YearId:int, Year:int, Value:double);

useful_columns = FOREACH fbs GENERATE CountryId, ItemId, Year, Value;

countries = FOREACH useful_columns GENERATE CountryId, Year;
countries = DISTINCT countries;

Col1 = FILTER useful_columns BY ItemId == 2901;
Col2 = FILTER useful_columns BY ItemId == 2903;
Col3 = FILTER useful_columns BY ItemId == 2905;
Col4 = FILTER useful_columns BY ItemId == 2907;
Col5 = FILTER useful_columns BY ItemId == 2909;
Col6 = FILTER useful_columns BY ItemId == 2913;
Col7 = FILTER useful_columns BY ItemId == 2914;
Col8 = FILTER useful_columns BY ItemId == 2918;
Col9 = FILTER useful_columns BY ItemId == 2919;
Col10 = FILTER useful_columns BY ItemId == 2941;
Col11 = FILTER useful_columns BY ItemId == 2943;
Col12 = FILTER useful_columns BY ItemId == 2946;
Col13 = FILTER useful_columns BY ItemId == 2948;
Col14 = FILTER useful_columns BY ItemId == 2949;
Col15 = FILTER useful_columns BY ItemId == 2960;

same = JOIN countries BY ($0,$1), Col1 BY (CountryId, Year);
same1 = JOIN same BY ($0,$1), Col2 BY (CountryId, Year);
same2 = JOIN same1 BY ($0,$1), Col3 BY (CountryId, Year);
same3 = JOIN same2 BY ($0,$1), Col4 BY (CountryId, Year);
same4 = JOIN same3 BY ($0,$1), Col5 BY (CountryId, Year);
same5 = JOIN same4 BY ($0,$1), Col6 BY (CountryId, Year);
same6 = JOIN same5 BY ($0,$1), Col7 BY (CountryId, Year);
same7 = JOIN same6 BY ($0,$1), Col8 BY (CountryId, Year);
same8 = JOIN same7 BY ($0,$1), Col9 BY (CountryId, Year);
same9 = JOIN same8 BY ($0,$1), Col10 BY (CountryId, Year);
same10 = JOIN same9 BY ($0,$1), Col11 BY (CountryId, Year);
same11 = JOIN same10 BY ($0,$1), Col12 BY (CountryId, Year);
same12 = JOIN same11 BY ($0,$1), Col13 BY (CountryId, Year);
same13 = JOIN same12 BY ($0,$1), Col14 BY (CountryId, Year);
same14 = JOIN same13 BY ($0,$1), Col15 BY (CountryId, Year);

Country_vector = FOREACH same14 GENERATE $0, $1, $5, $9, $13, $17, $21, $25, $29, $33, $37, $41, $45, $49, $53, $57, $61;

STORE useful_columns INTO '/user/final/FBS_all_id' USING PigStorage(',');
STORE Country_vector INTO '/user/final/FBS_all_country' USING PigStorage(',');

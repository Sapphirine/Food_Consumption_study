f = FBS2010country;
fbscereals = f(:,4)./f(:,2);
fbsveg = (f(:,9)+f(:,10))./f(:,2);
fbsroots = f(:,5)./f(:,2);
fbsprotein = (f(:,12)+f(:,14)+f(:,15)+f(:,16))./f(:,2);
fbssugeroil = (f(:,6)+f(:,7)+f(:,8)+f(:,13))./f(:,2);
fbsstruct = [fbscereals fbsveg fbsroots fbsprotein fbssugeroil];
[idx1, c1] = kmeans(fbsstruct,5);
rows = zeros(182,1);
sortcountry = country_name(1:182);
for i=1:182
    rows(i)= find(country_code==f(i,1));
    sortcountry(i) = country_name(rows(i));
end

center1=sortcountry(idx1==1);
center1struct=fbsstruct(idx1==1,:);
center2=sortcountry(idx1==2);
center2struct=fbsstruct(idx1==2,:);
center3=sortcountry(idx1==3);
center3struct=fbsstruct(idx1==3,:);
center4=sortcountry(idx1==4);
center4struct=fbsstruct(idx1==4,:);
center5=sortcountry(idx1==5);
center5struct=fbsstruct(idx1==5,:);


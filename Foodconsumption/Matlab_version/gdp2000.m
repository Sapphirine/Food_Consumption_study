cgdp2010=zeros(182,2);
for i = 1:182
    for j = 1:222
        if strcmp(sortcountry{i}, CountryName1{j})
            cgdp2010(i,:) = [idx1(i) YR2010(j)];
            break
        end
    end
end
            
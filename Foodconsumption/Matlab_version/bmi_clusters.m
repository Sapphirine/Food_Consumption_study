cbmi2010 = zeros(71,7);
for i = 1:182
    for j = 1:255
        if strcmp(sortcountry{i}, countryindicator{j})
            cbmi2010(i,:) = [idx1(i) BMI2010(j,:)];
            break
        end
    end
end
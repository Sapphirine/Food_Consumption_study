#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Mon Dec 19 14:06:57 2016

@author: Yilan Ji

This file generates results and analysis based on Food Balance Data, GDP per capita and BMI(>25)%
includes:
    a. The clustering results of fbs for the chosen year, based on 5 dimention structure of food
    b. Average GDP per capita in each cluster
    c. Linear Regression on 5 components of food supply and GDP of each country, Analysis of model
    d. Linear Regression on 5 components of food supply and average GDP in each cluster,  Analysis of model
    e. Linear Regression on 5 components of food supply and BMI overweight index(>25)(%), Anylysis of model
    f. PCA reduces the dimentions of detailed food supply from 12 to 3, analysis the PCA results
    
"""
import pandas as pd
from sklearn.cluster import KMeans
import numpy as np
from sklearn import linear_model
from sklearn.decomposition import PCA
import  csv
#import matplotlib.pyplot as plt

#from pyspark.mllib.clustering import KMeans, KMeansModel

#a. The clustering results of fbs for the chosen year, based on 5 dimention structure of food
# Load and parse the data
year='2010'

data = pd.read_csv("/Users/Jillian/Downloads/bdpj/FBS_all_country.csv", sep=',', header=None)
data_year = data.where(data[1]==year)
f = data_year.dropna()
for col in range(0,17):
    f[col] = [float(i) for i in f[col]]

fbscountry = np.array(f[0])
fbscereals = np.divide(np.array(f[4]), np.array(f[2]))
fbsveg = np.divide(np.add(np.array(f[9]), np.array(f[10])), np.array(f[2]))
fbsroots = np.divide(np.array(f[5]), np.array(f[2]))
fbsprotein = np.divide(np.sum([np.array(f[12]), np.array(f[14]), np.array(f[15]), np.array(f[16])], axis = 0), np.array(f[2]))
fbssugeroil = np.divide(np.sum([np.array(f[6]), np.array(f[7]), np.array(f[8]), np.array(f[13])], axis = 0), np.array(f[2]))
fbsstruct = np.array([fbscereals, fbsveg, fbsroots, fbsprotein, fbssugeroil])
mask = np.isnan(fbsstruct)
fbsstruct[mask] = np.interp(np.flatnonzero(mask), np.flatnonzero(~mask), fbsstruct[~mask])

# Build the model (cluster the data)
clusters = KMeans(n_clusters=5, random_state=0).fit(fbsstruct.T)

print(clusters.cluster_centers_)

countrylist = pd.read_csv("/Users/Jillian/Downloads/bdpj/FBS_code_countryname.csv/FBS_code_countryname.csv", sep=',', header=None)
country_name = np.array(countrylist[1])
country_code = np.array(countrylist[0])
sortcountry = country_name[0:len(fbscountry.T)]
rows = country_code[0:len(fbscountry.T)]
cluster0 = []
cluster1 = []
cluster2 = []
cluster3 = []
cluster4 = []
cluster_year = []
cluster_year1 = []
cluster_year2 = []

#b. Average GDP per capita in each cluster

GDP_all = pd.read_csv("/Users/Jillian/Downloads/bdpj/GDP_1961_2013.csv", sep=',', header=None)[1:]
GDP_year = np.array(GDP_all[56-(2013-int(year))])
GDP_country = np.array(GDP_all[2])
GDP_sorted = []
cc0 = []
cc1 = []
cc2 = []
cc3 = []
cc4 = []
use = []

for i in range(0,len(fbscountry.T)):
    rows[i]= country_code[country_code.tolist().index(fbscountry[i])]
    sortcountry[i] = country_name[country_code.tolist().index(fbscountry[i])]
    
    cluster_year.append([rows[i], sortcountry[i], clusters.labels_[i], 
                         fbsstruct.T[i][0], fbsstruct.T[i][1], fbsstruct.T[i][2],
                         fbsstruct.T[i][3], fbsstruct.T[i][4]])
    cluster_year1.append([rows[i], clusters.labels_[i], fbsstruct.T[i][:]])
    cluster_year2.append([sortcountry[i], clusters.labels_[i], fbsstruct.T[i][:]])
    
    if clusters.labels_[i]==0:
        cluster0.append([rows[i], sortcountry[i], fbsstruct.T[i][:]])
        cc0.append(i)
    elif clusters.labels_[i]==1:
        cluster1.append([rows[i], sortcountry[i], fbsstruct.T[i][:]])
        cc1.append(i)
    elif clusters.labels_[i]==2:
        cluster2.append([rows[i], sortcountry[i], fbsstruct.T[i][:]])
        cc2.append(i)
    elif clusters.labels_[i]==3:
        cluster3.append([rows[i], sortcountry[i], fbsstruct.T[i][:]])
        cc3.append(i)
    elif clusters.labels_[i]==4:
        cluster4.append([rows[i], sortcountry[i], fbsstruct.T[i][:]])
        cc4.append(i)
        
    if sortcountry[i] in GDP_country:
        if GDP_year[GDP_country.tolist().index(sortcountry[i])]=='..':
            GDP_sorted.append(0)
        else:
            GDP_sorted.append(GDP_year[GDP_country.tolist().index(sortcountry[i])])
            use.append(i)
            if clusters.labels_[i]==0:
                cc0.append(i)
            elif clusters.labels_[i]==1:
                cc1.append(i)
            elif clusters.labels_[i]==2:
                cc2.append(i)
            elif clusters.labels_[i]==3:
                cc3.append(i)
            elif clusters.labels_[i]==4:
                cc4.append(i)

    else:
        GDP_sorted.append(0)

#with open("/Users/Jillian/Desktop/fbs_cluster_2012.csv","w") as writer:
#    wr = csv.writer(writer,delimiter="\n")
#    wr.writerow(cluster_year)

#with open("/Users/Jillian/Desktop/clustecenters_2010.csv","w") as writer:
#    wr = csv.writer(writer,delimiter="\n")
#    wr.writerow(clusters.cluster_centers_)
        
GDP0 = np.mean([float(GDP_sorted[i]) for i in cc0])
GDP1 = np.mean([float(GDP_sorted[i]) for i in cc1])
GDP2 = np.mean([float(GDP_sorted[i]) for i in cc2])
GDP3 = np.mean([float(GDP_sorted[i]) for i in cc3])
GDP4 = np.mean([float(GDP_sorted[i]) for i in cc4])
GDP_cluster = [GDP0, GDP1, GDP2, GDP3, GDP4]

print('Average GDP in each cluster: \n', GDP_cluster)


#c. Linear Regression on 5 components of food supply and GDP of each country, Analysis of model

X_train = [fbsstruct.T[i]*f[2][f.index[i]] for i in use[0:110]]
y_train = [float(GDP_sorted[i])/1000 for i in use[0:110]]
X_test = [fbsstruct.T[i]*f[2][f.index[i]] for i in use[90:]]
y_test = [float(GDP_sorted[i])/1000 for i in use[90:]]
           
regr = linear_model.LinearRegression(fit_intercept=True, normalize=True)
regr.fit(X_train, y_train)

# The coefficients
print('Coefficients: \n', regr.coef_)
print('Mean predict GDP: ', np.mean((regr.predict(X_test))))
# The mean variance of error
print("Mean variance of error: %.2f"
      % np.sqrt(np.mean((regr.predict(X_test) - y_test) ** 2)))
# Explained variance score: 1 is perfect prediction
print('Variance score: %.2f' % regr.score(X_test, y_test))

#d. Linear Regression on 5 components of food supply and average GDP in each cluster,  Analysis of model

X_train0 = [fbsstruct.T[i]*f[2][f.index[i]] for i in use[0:110]]
y_train0 = [GDP_cluster[clusters.labels_[i]]/1000 for i in use[0:110]]
X_test0 = [fbsstruct.T[i]*f[2][f.index[i]]for i in use[90:]]
y_test0 = [GDP_cluster[clusters.labels_[i]]/1000 for i in use[90:]]
           
regr = linear_model.LinearRegression(fit_intercept=True, normalize=True)
regr.fit(X_train0, y_train0)

# The coefficients
print('Coefficients: \n', regr.coef_)
print('Mean predict GDP: ', np.mean((regr.predict(X_test0))))
# The mean variance of error
print("Mean variance of error: %.2f"
      % np.sqrt(np.mean((regr.predict(X_test0) - y_test0) ** 2)))
# Explained variance score: 1 is perfect prediction
print('Variance score: %.2f' % regr.score(X_test0, y_test0))


#e. Linear Regression on 5 components of food supply and BMI overweight index(>25)(%), Anylysis of model

BMI_all = pd.read_csv("/Users/Jillian/Downloads/bdpj/BMIadults_overweight(>25.0).csv", sep=',', header=None)[1:]

BMI_year = np.array(BMI_all[2011-int(year)])
BMI_country = np.array(BMI_all[0])
BMI = pd.DataFrame(np.array([BMI_country, BMI_year]).T).dropna()
fbs_BMIsorted = []
fbs_BMI_cluster = []

for i in BMI.index:
    if BMI[0][i] in sortcountry:
        ind = sortcountry.tolist().index(BMI[0][i])
        fbs_BMIsorted.append([BMI[1][i],fbsstruct.T[ind]*f[2][f.index[ind]]])
        fbs_BMI_cluster.append([BMI[1][i], sortcountry.tolist().index(BMI[0][i])])

BMI0 = np.mean([float(fbs_BMI_cluster[i][0]) for fbs_BMI_cluster[i][1] in cc0])
BMI1 = np.mean([float(fbs_BMI_cluster[i][0]) for fbs_BMI_cluster[i][1] in cc1])
BMI2 = np.mean([float(fbs_BMI_cluster[i][0]) for fbs_BMI_cluster[i][1] in cc2])
BMI3 = np.mean([float(fbs_BMI_cluster[i][0]) for fbs_BMI_cluster[i][1] in cc3])
BMI4 = np.mean([float(fbs_BMI_cluster[i][0]) for fbs_BMI_cluster[i][1] in cc4])
BMI_cluster = [BMI0, BMI1, BMI2, BMI3, BMI4]

print('Average BMI in each cluster: \n', BMI_cluster)

        
        
X_trainbmi = [fbs_BMIsorted[i][1] for i in range(0,50)]
y_trainbmi = [float(fbs_BMIsorted[i][0]) for i in range(0,50)]
X_testbmi = [fbs_BMIsorted[i][1] for i in range(40,len(fbs_BMIsorted))]
y_testbmi = [float(fbs_BMIsorted[i][0]) for i in range(40,len(fbs_BMIsorted))]

regrbmi = linear_model.LinearRegression(fit_intercept=True, normalize=True)
regrbmi.fit(X_trainbmi, y_trainbmi)

# The coefficients
print('Coefficients: \n', regrbmi.coef_)
print('Mean predict BMI(>25)%: ', np.mean((regrbmi.predict(X_testbmi))))
# The mean variance of error
print("Mean variance of error: %.2f"
      % np.sqrt(np.mean((regrbmi.predict(X_testbmi) - y_testbmi) ** 2)))
# Explained variance score: 1 is perfect prediction
print('Variance score: %.2f' % regrbmi.score(X_testbmi, y_testbmi))


# f. PCA reduces the dimentions of detailed food supply from 12 to 3, analysis the PCA results

fbs_detail = np.array([np.array(f[i]) for i in np.array([4,5,6,7,8,9,10,12,13,14,15,16])])
fbs_pca = []
for i in BMI.index:
    if BMI[0][i] in sortcountry:
        ind = sortcountry.tolist().index(BMI[0][i])
        fbs_pca.append(fbs_detail.T[ind] + float(BMI[1][i]))

pca = PCA(n_components=3)
pca.fit(fbs_pca)
pca.transform(fbs_pca)
print('explained_variance_ratio_=', pca.explained_variance_ratio_) 
print('get parameters =', pca.get_params()) 

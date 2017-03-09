#!/bin/bash

# svn co build
# author: pengpeng
# time: 2015-09-25

source ~/.bash_profile

D=`date +%Y%m%d`

systemName=$1

svnURL=$2

env=$3

rootpath=$4

infofile=$rootpath/.svn.info

codePath=$rootpath/codePath

repository=$rootpath/repository

if [ -d $rootpath ]; then
    rm -rf $rootpath/*
    mkdir -p $repository
    mkdir -p $codePath
else
   mkdir -p $repository
   mkdir -p $codePath
fi


if [ "$systemName" = "" ]; then 
    echo "lost first param:systemName!"
    exit 1
fi

if [ "$svnURL" = "" ]; then
    echo "lost second param:svnURL!"
    exit 1
fi

if [ "$env" = "" ]; then
    echo "lost third param:env!"
    exit 1
fi

webroot=/opt/wwwroot/ops
warFilePath=$webroot/warFiles/$D
if [ ! -d "$warFilePath/$systemName" ]; then
    echo "create system path: $warFilePath/$systemName"
    mkdir -p $warFilePath/$systemName
else
    echo "find exist destination path: $warFilePath/$systemName"
fi

echo "deletting $codePath ..."
rm -rf $codePath
if [ $? != 0 ] ; then
    echo "force delete $codePath fail!"
    exit 1;
fi

function checkout()
{
    echo ""
    echo "checkout sources from $1"
    svn --username yuxiaodong --password 000000 --force co $1 $2 | tee $infofile
    if [ $? = 0 ]; then
       chkinfo=`tail -n1 $infofile`
       if [[ $chkinfo =~ "Checked out revision" ]]; then
                echo -e "\nsources code checkout success!\n"
        else
                echo -e "\nsources code checkout fail!\n"
                exit 1
        fi
    else
        echo -e "\nsources code checkout fail!\n"
        exit 1
    fi
}

echo "check out source code of $systemName from $svnURL"
checkout $svnURL $codePath

svnVersion=`grep "At revision" $infofile | awk '{ print $3 }' | awk -F "." '{ print $1 }'`
if [ "$svnVersion" = "" ]; then
    svnVersion=`grep "Updated to revision" $infofile | awk '{ print $4 }' | awk -F "." '{ print $1 }'`
    if [ "$svnVersion" = "" ]; then
        svnVersion=`grep "Checked out revision" $infofile | awk '{ print $4 }' | awk -F "." '{ print $1 }'`
    fi
fi
echo "svn version: $svnVersion"

currentPath=`pwd`

cd $codePath

propertiesFile="$env-config.properties"
propertiesURL="http://xxx.xianglin.com/properties/$systemName/$env"
# if [ ! -f "$propertiesFile" -o "$env" != "dev" ]; then
if [ ! -f "$propertiesFile" ]; then
#    echo -e "\nfetch $env-config.properties from $propertiesURL"
#    wget "$propertiesURL" -o "$propertiesFile"
#    if [ $? != 0 ]; then
#        echo "\nfetch $env-config.properties fail, from $propertiesURL"
#        exit 1
#    fi
#    echo -e "wirte config properties to $propertiesFile over!"
    echo "can not find configFile:$propertiesFile"
    cd $currentPath
    exit 1
else
    echo "env: $env, use existing config file: $propertiesFile"
fi

echo -e "\nexecutting mvn clean package, please wait..."
mvn clean package -Denv=$env -DsvnVersion=$svnVersion -DskipTests -Dmaven.repo.local=$repository
if [ $? != 0 ]; then
    echo "execute mvn clean package fail!"
    cd $currentPath
    exit 1
fi

webtarget=assembly/assembly/target/
othertarget=target/
if [ ! -d "$webtarget" ]; then
    target=$othertarget
else
    target=$webtarget
fi
#cd ./assembly/assembly/target/
cd $target
warFile=`ls *.war`
destWarFile=$warFilePath/$systemName/$warFile
echo "destWarFile:$destWarFile"
if [ -f "$destWarFile" ]; then
    echo "delete old warFile:$destWarFile"
    rm $destWarFile
fi
echo "copy $codePath/$target/$warFile to $warFilePath/$systemName"
cp $warFile $destWarFile 
if [ $? != 0 ]; then
    echo -e "\ncopy $codePath/$target/$warFile to $warFilePath/$systemName fail\n"
    rm -rf $rootpath
    cd $currentPath
    exit 1
else
    rm -rf $rootpath
    echo "$warFilePath/$systemName/$warFile"
fi

cd $currentPath


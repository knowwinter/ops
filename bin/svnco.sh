#!/bin/sh

source /home/admin/.bash_profile

systemName=$1

svnURL=$2

version=$3


rootpath=$4

infofile=$rootpath/.svn.info

codePath=$rootpath/codePath


if [ -d $rootpath ]; then
    rm -rf $rootpath/*
    mkdir -p $codePath
else
   mkdir -p $codePath
fi


D=`date +%Y%m%d`

if [ "$systemName" = "" ]; then 
    echo "lost first param:systemName!"
    exit 1
fi

if [ "$svnURL" = "" ]; then
    echo "lost second param:svnURL!"
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
currentPath=`pwd`

cd $codePath

zip -r ${warFilePath}/${systemName}/${systemName}_${version}.zip * | tee ~/.zip.info
if [ $? = 0 ]; then
    rm -rf $rootpath
    echo  "${warFilePath}/${systemName}/${systemName}_${version}.zip"
    exit 0
else
    rm -rf $rootpath
    echo -e "\nsources code to pack fail!\n"
    exit 1
fi


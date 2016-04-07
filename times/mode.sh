#!/bin/bash -x

echo "IPADDR=$1"       >>./temp.txt
echo "NETMASK=$2"     >>./temp.txt
cat temp.txt

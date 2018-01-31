import urllib.request as r

for line in r.urlopen('https://drive.google.com/embeddedfolderview?id=0B-xIaV4W0kk4X0FqalBOajNtYkE#list'):
    print(line)

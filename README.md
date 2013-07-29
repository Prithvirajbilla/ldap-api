ldap-api
========

provides usefull information (in JSON) to create ldap-authentication of servers hosted outside IITB.

USAGE
========
<p>
index.php?user=&lt;name&gt; <br />
index.php/&lt;username&gt; <br/>
index.php?user=&lt;name&gt;&pass=encodedpass
<br/>
</p>
results a json

Example
========
<pre style="word-wrap: break-word; white-space: pre-wrap;">{
  "ldapid":"prithviraj",
  "fname":"BILLA MADHUKAR",
  "lname":"PRITHVIRAJ",
  "rollno":"110050065",
  "mail":"prithviraj@iitb.ac.in",
  "dept":"cse"
}</pre>

With Bind
<pre style="word-wrap: break-word; white-space: pre-wrap;">{
  "ldapid":"prithviraj",
  "fname":"BILLA MADHUKAR",
  "lname":"PRITHVIRAJ",
  "rollno":"110050065",
  "mail":"prithviraj@iitb.ac.in",
  "dept":"cse",
  "bind":true
}</pre>
Future Changes
==============
<p> For now its completed \m/ </p>
<h3> include search user with approximate string and get all students with particular matching, etc.
</h3>


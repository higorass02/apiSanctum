<h1 style="text-align: center">Helps</h1>
<ul>
    <li>
        <b>REGISTER (localhost/api/auth/register)</b>
        <table>
            <tr style="text-align: center">
                <th>PROTOCOL</th>
                <th>BODY</th>
                <th>HEADERS</th>
            </tr>
            <tr>
                <td>POST</td>
                <td>
                    Example:<br>
                        {<br>
                            &nbsp"name":"Exemplo 1",<br>
                            &nbsp"email":"exe@email.com",<br>
                            &nbsp"password":"password123",<br>
                            &nbsp"password_confirmation":"password123",<br>
                            &nbsp"token_name":"it's my first token"<br>
                        }
                </td>
                <td>
                    Example:<br> 
                        {<br>
                            &nbsp"Content-Type": "application/json"<br>
                            &nbsp"Accept": "application/json"<br>
                        }
                </td>
            </tr>
        </table>
    </li>
    <li>
        <b>LOGIN (localhost/api/auth/login)</b>
        <table>
            <tr style="text-align: center">
                <th>PROTOCOL</th>
                <th>BODY</th>
                <th>HEADERS</th>
            </tr>
            <tr>
                <td>POST</td>
                <td>
                    Example:<br>
                        {<br>
                            &nbsp"email":"exe@email.com",<br>
                            &nbsp"password":"password123",<br>
                        }
                </td>
                <td>
                    Example:<br> 
                        {<br>
                            &nbsp"Content-Type": "application/json"<br>
                            &nbsp"Accept": "application/json"<br>
                        }
                </td>
            </tr>
        </table>
    </li>
        <li><b>LOGOUT (localhost/api/auth/logout)</b>
        <table>
            <tr style="text-align: center">
                <th>PROTOCOL</th>
                <th>BODY</th>
                <th>HEADERS</th>
            </tr>
            <tr>
                <td>DELETE</td>
                <td>No Body</td>
                <td>
                    Example:<br> 
                        {<br>
                            &nbsp"Accept": "application/json"<br>
                            &nbsp"authorization":"Bearer 5|GxlIACU0T0ULE2Vs3Guf2aRt62mtrUG5B2TMyJ3m"<br>
                        }
                </td>
            </tr>
        </table>
    </li>
        <li><b>ME (localhost/api/auth/me)</b>
        OBS: find first User
        <table>
            <tr style="text-align: center">
                <th>PROTOCOL</th>
                <th>BODY</th>
                <th>HEADERS</th>
            </tr>
            <tr>
                <td>GET</td>
                <td>No Body</td>
                <td>
                    Example:<br> 
                        {<br>
                            &nbsp"Content-Type": "application/json"<br>
                            &nbsp"Accept": "application/json"<br>
                        }
                </td>
            </tr>
        </table>
    </li>
</ul>
Ref:<a href="https://www.youtube.com/watch?v=iDepVTB2kPM&ab_channel=BeerandCode">Youtube link</a>

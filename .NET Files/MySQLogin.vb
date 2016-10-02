Imports System.Collections.Generic
Imports System.Collections.Specialized
Imports System.IO
Imports System.Linq
Imports System.Net
Imports System.Security.Cryptography
Imports System.Text
Imports System.Threading.Tasks

Class mySQLogin
#Region "config"
    Private Shared create_userURL As String = "http://.../create_user.php"
    Private Shared check_userURL As String = "http://.../check_user.php"
#End Region
    Public Shared Function register(username As String, password As String) As Integer
        Try
            Using client = New WebClient()
                Dim values = New NameValueCollection()
                values("username") = username
                values("password") = enc.obfuscate(password)
                Dim response = client.UploadValues(create_userURL, values)
                Dim responseString = Encoding.[Default].GetString(response)
                If responseString.Contains("New record created successfully") Then
                    Return 1
                End If
                If responseString.Contains("Username already taken") Then
                    Return 2
                End If
            End Using
        Catch generatedExceptionName As Exception
            Return 0
        End Try
        Return 0
    End Function
    Public Shared Function login(username As String, password As String) As Integer
        Try
            Using client = New WebClient()
                Dim values = New NameValueCollection()
                values("username") = username
                values("password") = enc.obfuscate(password)
                Dim response = client.UploadValues(check_userURL, values)
                Dim responseString = Encoding.[Default].GetString(response)
                If responseString.Contains("true->" + username.ToLower()) Then
                    Return 1
                ElseIf responseString.Contains("false->" + username.ToLower()) Then
                    Return 2
                End If
                Return 0
            End Using
        Catch generatedExceptionName As Exception
            Return 0
        End Try
    End Function
End Class
Class enc
    Public Shared Function obfuscate(s As String) As String
        Dim ogS As String = s
        Dim run As Integer = s.Length
        Dim insX As Integer = 3
        For i As Integer = 0 To run + (Math.Pow(insX, insX) - 1)
            Dim indX As Integer = i + (i * insX)
            Dim toEnc As String = s.Substring(indX - i, insX)
            Dim nData As String = encode(toEnc)
            s = s.Insert(indX, nData)
        Next
        Return s.Replace(ogS, Nothing).Replace(s.Substring(0, run), Nothing)
    End Function
    Private Shared Function encode(s As String) As String
        Dim pBytes = System.Text.Encoding.ASCII.GetBytes(s)
        Return System.Convert.ToBase64String(pBytes)
    End Function
End Class
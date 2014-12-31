Option Explicit On
Imports System.Runtime.InteropServices
Imports System.Diagnostics
Imports System
Imports System.Text
Imports System.IO
Imports System.Net
Imports System.Net.Sockets
Imports Microsoft.VisualBasic
Imports System.Security.Permissions
Public Class LoginForm

    ' TODO: Insert code to perform custom authentication using the provided username and password 
    ' (See http://go.microsoft.com/fwlink/?LinkId=35339).  
    ' The custom principal can then be attached to the current thread's principal as follows: 
    '     My.User.CurrentPrincipal = CustomPrincipal
    ' where CustomPrincipal is the IPrincipal implementation used to perform authentication. 
    ' Subsequently, My.User will return identity information encapsulated in the CustomPrincipal object
    ' such as the username, display name, etc.

    Private Sub OK_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles OK.Click
        OK.Text = "Please wait..."
        Dim WebClient1 As New WebClient()
        Dim returndata As Byte() = WebClient1.DownloadData(DOMAIN + "login/applogin/?email=" + UsernameTextBox.Text + "&password=" + PasswordTextBox.Text)
        Dim logindata As String = Encoding.ASCII.GetString(returndata)
        If Trim(logindata).Length > 0 Then
            If Trim(logindata) = "false" Then
                MsgBox("Invalid Login Attempt", MsgBoxStyle.Exclamation, "Error")
                OK.Text = "&Sign-in"
            Else
                Console.WriteLine(logindata)
                Dim s As String() = logindata.Split(New Char() {"^"c})
                USER_INFO.firstname = s(0)
                USER_INFO.lastname = s(1)
                USER_INFO.username = s(2)
                USER_INFO.email = s(3)
                USER_INFO.photoid = s(4)
                USER_INFO.id = s(5)
                Me.Hide()
                demeterclient.Show()

                OK.Text = "&Sign-in"
            End If

        Else
            MsgBox("Please check your network configuration", MsgBoxStyle.Exclamation, "Error")
            OK.Text = "&Sign-in"

        End If
    End Sub


    Private Sub Timer1_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Timer1.Tick
        If GotInternet() Then
            lblstats.Text = "Connection Established"
            CONNECTION_ACTIVE = True
        Else

            lblstats.Text = "Connection Disconnected"
            CONNECTION_ACTIVE = False
        End If
    End Sub
    Public Function GotInternet() As Boolean
        Dim req As System.Net.HttpWebRequest
        Dim res As System.Net.HttpWebResponse
        GotInternet = False
        Try
            req = CType(System.Net.HttpWebRequest.Create("http://www.centraleffects.com"), System.Net.HttpWebRequest)
            res = CType(req.GetResponse(), System.Net.HttpWebResponse)
            req.Abort()
            If res.StatusCode = System.Net.HttpStatusCode.OK Then
                GotInternet = True
            End If
        Catch weberrt As System.Net.WebException
            GotInternet = False
        Catch except As Exception
            GotInternet = False
        End Try
    End Function

    Private Sub LoginForm_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
       
    End Sub
End Class

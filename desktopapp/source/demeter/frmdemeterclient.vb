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


Public Class demeterclient
    Dim mouseclickcounter As Integer
    Dim keyboardhitcounter As Integer
    Dim tempPath = System.IO.Path.GetTempPath & "Demeter Time Tracker"
    Dim ScreenshotPath As String = tempPath & "\screenshot"
    Dim startTime As DateTime = Now
    Private Declare Function GetAsyncKeyState Lib "user32.dll" (ByVal vKey As System.Int16) As Int16
    Dim balloonEvent As String = ""
    Dim RemoteImgUrl As String = ""
    Public Event BalloonTipClicked As EventHandler
    Public Sub SendFile( _
              ByVal fileName As String, _
              ByVal preBuffer As Byte(), _
              ByVal postBuffer As Byte(), _
              ByVal flags As TransmitFileOptions _
             )

    End Sub

    Private Sub Timer1_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles RunTimer.Tick
        ' If GetAsyncKeyState(Keys.F6) <> 0 Then
        'MsgBox("HI")
        'code here
        'End If
        'lbmousepointer.Items.Add(GetAsyncKeyState())


        ' 'display timer
        'lbltimer.Text = FormatNumber((Minute(Now) - Minute(startTime)), 0) & ":" & FormatNumber((Second(Now) - Second(startTime)), 0).ToString()
        'lblstarttime.Text = FormatDateTime(startTime, DateFormat.ShortTime)

        'take screenshot every 10 minutes and send to server
        'If Val((Minute(Now) - Minute(startTime))) = 2 Then
        ' takescreenshot()
        ' NotifyIcon1.BalloonTipText = "Screenshot has been save to " & path & vbLf & "Click this balloon to Preview"
        ' NotifyIcon1.ShowBalloonTip(500)
        ' startTime = Now
        ' balloonEvent = "screenshot"
        ' End If

        'If GotInternet() Then
        'lblstats.Text = "Connection Established"
        'CONNECTION_ACTIVE = True
        'Else

        'lblstats.Text = "Connection Disconnected"
        'CONNECTION_ACTIVE = False
        'End If
        Dim endtime As DateTime = DateTime.Now
        Dim CUR_TIME As TimeSpan = endtime - TIME_STARTED
        'display running time
        runningtime.Text = CUR_TIME.ToString("hh':'mm':'ss")
    End Sub

    Private Sub demeterclient_Disposed(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Disposed
        End
    End Sub

    Private Sub demeterclient_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        'generate random string
        RANDOM_STRING = GENERATE_RANDOM_NUMBER()
        LastTenMinutes.Text = Now()
        Me.Width = 360
        RANDOM_STRING_SCREENSHOT = RANDOM_NUMBERS_FOR_SCREENSHOT()


        photoid.ImageLocation = USER_INFO.photoid
        firstname.Text = USER_INFO.firstname + " " + USER_INFO.lastname

        'takescreenshot()
        'check temp dir and create if none exist
        demeterTempDir()

        'disable fields
        cbproject.Enabled = True
        cbtask.Enabled = True
        cbmilestone.Enabled = True
        txtnotes.Enabled = True
        cbcompletion.Enabled = False
        cbisfinished.Enabled = False
        btntimerstart.Enabled = False
        btnupdatenotes.Enabled = False
        btnset.Enabled = False

        LIST_MILESTONE_INDEX.Add(0)
        cbmilestone.Items.Add("Default")
        cbmilestone.SelectedIndex = 0
        LIST_MILESTONE_INDEX.Add(0)
        cbtask.Items.Add("Default")
        cbtask.SelectedIndex = 0

        'load project for the specific user
        Dim WebClient1 As New WebClient()
        Dim returndata As Byte() = WebClient1.DownloadData(DOMAIN + "projects/appgetcompany/?userid=" + USER_INFO.id)
        Dim companies As String = Encoding.ASCII.GetString(returndata)
        If Trim(companies).Length > 0 Then
            LIST_COMPANIES = companies.Split(New Char() {"^"c})
            For x As Integer = 0 To LIST_COMPANIES.Length - 1

                Dim s As String() = LIST_COMPANIES(x).Split(New Char() {"~"c})

                LIST_COMPANIES_INDEX.Add(s(0))
                cbcompany.Items.Add(s(1))

            Next
        Else
            cbcompany.Enabled = False
        End If

    End Sub

    Private Sub takescreenshot()
        'create directory for screenshot if not exist
        If (Not System.IO.Directory.Exists(ScreenshotPath)) Then
            System.IO.Directory.CreateDirectory(ScreenshotPath)
        End If

        Dim b As New Bitmap(Screen.PrimaryScreen.Bounds.Width, Screen.PrimaryScreen.Bounds.Height, Imaging.PixelFormat.Format32bppArgb)

        Dim g As Graphics = Graphics.FromImage(b)
        g.CopyFromScreen(New Point(0, 0), New Point(0, 0), Screen.PrimaryScreen.Bounds.Size)


        ' path = Replace(Replace(Replace(Now.ToString, " ", "_"), "/", ""), ":", "")
        path = ScreenshotPath & "\" & RANDOM_STRING & ".png"
        b.Save(path)
        LAST_SCREENSHOT = path
        LAST_SCREENSHOT_FOR_UPLOAD = path
        pbscreenshot.ImageLocation = path
        NotifyIcon1.Visible = True
        NotifyIcon1.BalloonTipText = "Screenshot has been save to " & path & vbLf & "Click this balloon to Preview"
        NotifyIcon1.ShowBalloonTip(500)
        balloonEvent = "screenshot"
    End Sub

    Private Sub btnmakescreenshot_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnmakescreenshot.Click
        takescreenshot()
        If vbYes = MsgBox("Screenshot has been save to " & path & vbLf & "Do you want to preview the image?", vbYesNo) Then
            Process.Start(path)
        End If
    End Sub

    Private Sub NotifyIcon1_Click1(ByVal sender As Object, ByVal e As System.EventArgs) Handles NotifyIcon1.Click
        If (balloonEvent = "screenshot") Then
            Process.Start(path)
            balloonEvent = ""
        End If

        'bring window to front
        Me.Show()
        Me.BringToFront()
    End Sub


    Private Sub demeterclient_Resize(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Resize
        If Me.WindowState = FormWindowState.Minimized Then
            NotifyIcon1.Visible = True
            Me.Hide()
            NotifyIcon1.BalloonTipText = "Click me to show Demeter window"
            NotifyIcon1.ShowBalloonTip(500)
        End If
    End Sub
    Private Sub NotifyIcon1_BalloonTipClicked(ByVal sender As Object, ByVal e As EventArgs) _
     Handles NotifyIcon1.BalloonTipClicked
        If (balloonEvent = "screenshot") Then
            Process.Start(path)
            balloonEvent = ""
        End If

    End Sub

    Private Sub pbscreenshot_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles pbscreenshot.Click
        If LAST_SCREENSHOT <> "" Then
            Process.Start(LAST_SCREENSHOT)
        End If
    End Sub


    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        ' Dim result As String = SocketSendReceive("demeter.centraleffects.com", 80)
        ' Dim result = WebRequestPost()
        RemoteImgUrl = "http://demeter.centraleffects.com/upload/12232013_51810_PM.png"
        pbscreenshot.ImageLocation = RemoteImgUrl
        Dim WebClient1 As New WebClient
        'Using WebClient1 As New Net.WebClient
        'Attach the event handlers to the new WebClient.
        AddHandler WebClient1.UploadProgressChanged, AddressOf WebClient_UploadProgressChanged
        AddHandler WebClient1.UploadFileCompleted, AddressOf WebClient_UploadFileCompleted
        WebClient1.UploadFileAsync(New Uri("http://demeter.centraleffects.com/upload/index.php"), path)
        lsstats.Items.Insert(0, FormatDateTime(Now, DateFormat.ShortTime) & " - Upload Started.")
        'End Using

        



    End Sub

    Public Sub demeterTempDir()
        Dim demeterDir As String = tempPath
        If (Not System.IO.Directory.Exists(demeterDir)) Then
            System.IO.Directory.CreateDirectory(demeterDir)
        End If

    End Sub

#Region "connection to server"
    

    '------------------------------------------------------------------------
    Private Sub WebClient_UploadProgressChanged(ByVal sender As Object, ByVal e As System.Net.UploadProgressChangedEventArgs)
        Me.UpdateProgress(e.ProgressPercentage)
    End Sub

    Private Sub WebClient_UploadFileCompleted(ByVal sender As Object, ByVal e As System.Net.UploadFileCompletedEventArgs)
        Dim client = DirectCast(sender, WebClient)

        'Remove the event handlers
        RemoveHandler client.UploadProgressChanged, AddressOf WebClient_UploadProgressChanged
        RemoveHandler client.UploadFileCompleted, AddressOf WebClient_UploadFileCompleted

        Me.NotifyUploadComplete()
    End Sub

    Private Sub UpdateProgress(ByVal progressPercentage As Integer)
        If Me.InvokeRequired Then
            'We are on a background thread so re-invoke the method on the UI thread.
            Me.Invoke(New Action(Of Integer)(AddressOf UpdateProgress), progressPercentage)
        Else
            'We are on the UI thread so update the UI.
            ToolStripProgressBar1.Value = Integer.Parse(progressPercentage.ToString())
            ToolStripProgressBar1.ToolTipText = progressPercentage.ToString() + "% uploaded."
        End If
    End Sub

    Private Sub NotifyUploadComplete()
        If Me.InvokeRequired Then
            Me.Invoke(New Action(AddressOf NotifyUploadComplete))
        Else
            'lsstats.Items.Insert(0, FormatDateTime(Now, DateFormat.ShortTime) & " - Upload Complete.")
            statustextlab.Text = FormatDateTime(Now, DateFormat.ShortTime) & " - Upload Complete."
        End If
    End Sub

    Private Sub OnUploadComplete()
        ' If USER_INFO.last_screenshot <> "" Then
        ' pbscreenshot.ImageLocation = DOMAIN + "upload/" + USER_INFO.last_screenshot
        ' End If
    End Sub
#End Region
    Public Function CheckAddress(ByVal URL As String) As Boolean
        Try
            Dim request As WebRequest = WebRequest.Create(URL)
            Dim response As WebResponse = request.GetResponse()
        Catch ex As Exception
            Return False
        End Try
        Return True
    End Function
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
    Private Sub MenuStrip1_ItemClicked(ByVal sender As System.Object, ByVal e As System.Windows.Forms.ToolStripItemClickedEventArgs) Handles MenuStrip1.ItemClicked

    End Sub

    Private Sub LogoutToolStripMenuItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles LogoutToolStripMenuItem.Click
        Me.Hide()
        LoginForm.Show()
    End Sub

    Private Sub FileToolStripMenuItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles FileToolStripMenuItem.Click

    End Sub

    Private Sub cbcompany_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cbcompany.SelectedIndexChanged
        Dim selected = LIST_COMPANIES_INDEX(cbcompany.SelectedIndex)
        cbproject.Items.Clear()
        statustextlab.Text = "Please wait...."
        Dim WebClient1 As New WebClient()
        Dim returndata As Byte() = WebClient1.DownloadData(DOMAIN + "projects/appgetprojects/?userid=" + USER_INFO.id + "&companyid=" + selected)
        Dim projects As String = Encoding.ASCII.GetString(returndata)

        If WebClient1.ResponseHeaders.Count > 0 Then
            If projects.Length > 0 Then
                LIST_PROJECTS = projects.Split(New Char() {"^"c})
                cbproject.Items.Clear()
                For x As Integer = 0 To LIST_PROJECTS.Length - 1

                    Dim s As String() = LIST_PROJECTS(x).Split(New Char() {"~"c})

                    LIST_PROJECTS_INDEX.Add(s(0))
                    cbproject.Items.Add(s(1))

                Next
                cbproject.Enabled = True
            Else

            End If

        End If
        statustextlab.Text = "Request Completed."
    End Sub

    Private Sub cbproject_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cbproject.SelectedIndexChanged
        Dim selected = LIST_PROJECTS_INDEX(cbproject.SelectedIndex)
        cbmilestone.Items.Clear()
        cbtask.Items.Clear()
        statustextlab.Text = "Please wait.."
        Dim WebClient1 As New WebClient()
        Dim urls As String = DOMAIN + "projects/appgetmilestones/?userid=" + USER_INFO.id + "&projectid=" + selected
        Dim returndata As Byte() = WebClient1.DownloadData(urls)
        Dim milestone As String = Encoding.ASCII.GetString(returndata)
        Console.WriteLine(urls)
        If WebClient1.ResponseHeaders.Count > 0 Then
            If milestone.Length > 0 Then
                LIST_MILESTONE = milestone.Split(New Char() {"^"c})
                cbmilestone.Items.Clear()
                For x As Integer = 0 To LIST_MILESTONE.Length - 1

                    Dim s As String() = LIST_MILESTONE(x).Split(New Char() {"~"c})

                    LIST_MILESTONE_INDEX.Add(s(0))
                    cbmilestone.Items.Add(s(1))

                Next
                cbmilestone.Enabled = True
                btntimerstart.Enabled = True
            Else
                LIST_MILESTONE_INDEX.Add(0)
                cbmilestone.Items.Add("Default")
                cbmilestone.SelectedIndex = 0
            End If

        End If
        statustextlab.Text = "Request Completed."
    End Sub

    
    Private Sub cbtask_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cbtask.SelectedIndexChanged
        statustextlab.Text = "Please wait..."
        If cbtask.SelectedItem <> "" Then

            txtnotes.Enabled = True


            btntimerstart.Enabled = True
            ' btnupdatenotes.Enabled = True
            ' btnset.Enabled = True

            Dim selected As String = LIST_TASK_INDEX(cbtask.SelectedIndex)
            Console.WriteLine(LIST_TASK_INDEX(cbtask.SelectedIndex))

            'get task completion
            Dim WebClient1 As New WebClient()
            Dim urls As String = DOMAIN + "projects/appgettaskscompletion/?taskid=" + selected
            Console.WriteLine(urls)
            Dim returndata As Byte() = WebClient1.DownloadData(urls)
            Dim tasks As String = Encoding.ASCII.GetString(returndata)
            cbcompletion.SelectedItem = tasks
        End If
        statustextlab.Text = "Request Completed."
    End Sub

    Private Sub cbmilestone_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cbmilestone.SelectedIndexChanged
        Dim selected = LIST_MILESTONE_INDEX(cbmilestone.SelectedIndex)
        cbtask.Items.Clear()
        statustextlab.Text = "Please wait..."
        Dim WebClient1 As New WebClient()
        Dim urls As String = DOMAIN + "projects/appgettasks/?userid=" + USER_INFO.id + "&milestoneid=" + selected
        Console.WriteLine(urls)
        Dim returndata As Byte() = WebClient1.DownloadData(urls)
        Dim tasks As String = Encoding.ASCII.GetString(returndata)
        Console.WriteLine(tasks)
        LIST_TASK_INDEX.Clear()
        If WebClient1.ResponseHeaders.Count > 0 Then
            If tasks.Length > 0 Then
                LIST_TASK = tasks.Split(New Char() {"^"c})
                cbtask.Items.Clear()
                For x As Integer = 0 To LIST_TASK.Length - 1

                    Dim s As String() = LIST_TASK(x).Split(New Char() {"~"c})

                    LIST_TASK_INDEX.Add(s(0))

                    Dim ss As String() = s(1).Split(New Char() {"$"c})

                    cbtask.Items.Add(ss(0))


                Next
                cbtask.Enabled = True

            Else
                LIST_TASK_INDEX.Add(0)
                cbtask.Items.Add("Default")
                cbtask.SelectedIndex = 0
            End If
            cbcompletion.SelectedIndex = 0
        End If
        statustextlab.Text = "Request Completed."
    End Sub

    Private Sub btnset_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnset.Click
        statustextlab.Text = "Please wait..."
        If cbtask.SelectedItem <> "" Then
            Dim selected = LIST_TASK_INDEX(cbtask.SelectedIndex)

            'Upload Data to server
            Dim WebClient1 As New WebClient()
            Dim reqparm As New Specialized.NameValueCollection
            reqparm.Add("completion", cbcompletion.SelectedItem)
            Dim i As Boolean = cbisfinished.CheckState
            reqparm.Add("isfinished", i)
            reqparm.Add("userid", USER_INFO.id)
            reqparm.Add("taskid", selected)
            Console.WriteLine(reqparm)
            Dim response As Byte() = WebClient1.UploadValues(DOMAIN + "projects/appsetcompletion/", reqparm)
            Dim msg As String = Encoding.ASCII.GetString(response)
            If msg.Length > 0 Then
                MsgBox(msg)
            End If
        End If
        statustextlab.Text = "Request Completed."
    End Sub

    Private Sub btnupdatenotes_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnupdatenotes.Click
        If cbtask.SelectedItem <> "" Then
            If Trim(txtnotes.Text) <> "" Then
                'save to server
                Dim selected = LIST_TASK_INDEX(cbtask.SelectedIndex)

                'Upload Data to server
                Dim WebClient1 As New WebClient()
                Dim reqparm As New Specialized.NameValueCollection
                reqparm.Add("notes", Trim(txtnotes.Text))
                reqparm.Add("userid", USER_INFO.id)
                reqparm.Add("taskid", selected)
                Console.WriteLine(reqparm)
                Dim response As Byte() = WebClient1.UploadValues(DOMAIN + "projects/appsetnotes/", reqparm)
                Dim msg As String = Encoding.ASCII.GetString(response)
                If msg.Length > 0 Then
                    MsgBox(msg)
                    txtnotes.Text = ""
                End If
            End If
        End If
    End Sub

    Private Sub TimerEventsListener_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles TimerEventsListener.Tick
        Dim Result As Integer
        For i = 1 To 255                                  '-- This is Keycode in keyboard
            Result = GetAsyncKeyState(i)
            If Result = -32767 Then                '-- Keyboard pressed
                lbmousepointer.Items.Insert(0, FormatDateTime(Now, DateFormat.ShortTime) & " - " & i & "(" & CStr(Chr(i)) & ") is pressed") '-- Convert keycode into char

                If i = 1 Then
                    mouseclickcounter = mouseclickcounter + 1
                ElseIf i = 2 Then
                    mouseclickcounter = mouseclickcounter + 1
                Else
                    keyboardhitcounter = keyboardhitcounter + 1
                End If

            End If
        Next
        mouseclick.Text = mouseclickcounter
        keyboardhit.Text = keyboardhitcounter

        'get windows title
        listOpenwindows.Items.Clear()
        For Each p As Process In Process.GetProcesses
            If p.MainWindowTitle = Nothing Then
            Else
                listOpenwindows.Items.Add(p.MainWindowTitle)
            End If
        Next
       
    End Sub

    Private Sub TimerDataUploader_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles TimerDataUploader.Tick
        TimerDataUploader.Interval = 1000
        TenMinutes = DateDiff("n", LastTenMinutes.Text, Now())

        If LAST_SCREENSHOT_FOR_UPLOAD = "" Then
            If TenMinutes = RANDOM_STRING_SCREENSHOT Then
                'take Screenshot here
                takescreenshot()
                NotifyIcon1.BalloonTipText = "Screenshot has been save to " & path & vbLf & "Click this balloon to Preview"
                NotifyIcon1.ShowBalloonTip(500)
                startTime = Now
                balloonEvent = "screenshot"
            End If
        End If


        If TenMinutes = 10 Then
            'Do Something
            'Then reset Text1 to the new Now()

            cbcompletion.Enabled = True
            btnset.Enabled = True
            cbisfinished.Enabled = True

            statustextlab.Text = "Uploading Data..."
            Console.WriteLine(RANDOM_STRING)
            'determine time slot here
            Dim minute As Integer = Integer.Parse(DateTime.Now.ToString("mm"))
            Dim hour As String = DateTime.Now.ToString("HH")
            Dim logdate As String = DateTime.Now.ToString("yyyy-MM-dd")
            Dim timeslot As String = ""
            Select Case minute
                Case 0 To 10
                    timeslot = "10"
                Case 11 To 20
                    timeslot = "20"
                Case 21 To 30
                    timeslot = 30
                Case 31 To 40
                    timeslot = "40"
                Case 41 To 50
                    timeslot = "50"
                Case 51 To 60
                    timeslot = "60"
            End Select

            Dim opentabs As String = String.Join(",", listOpenwindows.Items.Cast(Of String).ToArray)
            Dim keystroke As Integer = keyboardhitcounter
            Dim mouseclick As Integer = mouseclickcounter


            'Upload Data to server
            Dim WebClient1 As New WebClient()
            Dim reqparm As New Specialized.NameValueCollection
            reqparm.Add("app_opentabs", opentabs)
            reqparm.Add("app_keystroke", keystroke)
            reqparm.Add("app_mouseclick", mouseclick)
            reqparm.Add("log_hour", hour)
            reqparm.Add("log_date", logdate)
            reqparm.Add("log_minute", timeslot)
            If cbtask.SelectedItem.ToString = "" Then
                reqparm.Add("task_id", "0")
            Else
                reqparm.Add("task_id", LIST_TASK_INDEX(cbtask.SelectedIndex))
            End If


            reqparm.Add("project_id", LIST_PROJECTS_INDEX(cbproject.SelectedIndex))
            reqparm.Add("user_id", USER_INFO.id)
            reqparm.Add("notes", txtnotes.Text)
            reqparm.Add("screenshot_id", RANDOM_STRING)
            Console.WriteLine(reqparm)
            Dim response As Byte() = WebClient1.UploadValues(DOMAIN + "projects/apptimelog/", reqparm)
            Dim msg As String = Encoding.ASCII.GetString(response)
            If msg.Length > 0 Then
                ' statustextlab.Text = msg
                Console.WriteLine(msg)
            End If

            'Upload screenshot to server
            Dim WebClient2 As New WebClient
            'Using WebClient1 As New Net.WebClient
            'Attach the event handlers to the new WebClient.
            AddHandler WebClient2.UploadProgressChanged, AddressOf WebClient_UploadProgressChanged
            AddHandler WebClient2.UploadFileCompleted, AddressOf WebClient_UploadFileCompleted
            WebClient2.UploadFileAsync(New Uri(DOMAIN + "upload/index.php"), LAST_SCREENSHOT_FOR_UPLOAD)
            statustextlab.Text = FormatDateTime(Now, DateFormat.ShortTime) & " - Upload Started."
            ToolStripProgressBar1.Value = 0


            'add new random string
            RANDOM_STRING = GENERATE_RANDOM_NUMBER()

            LastTenMinutes.Text = Now()
            LAST_SCREENSHOT_FOR_UPLOAD = ""

        Else
            'Don't Do Something
        End If
    End Sub

    Private Sub btntimerstart_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btntimerstart.Click
        If TimerDataUploader.Enabled = False Then

            TimerDataUploader.Enabled = True
            btntimerstart.Text = "Stop"
            statustextlab.Text = "Timer Started at " + FormatDateTime(Now, DateFormat.ShortTime) + "."

            TIME_STARTED = DateTime.Now
            RunTimer.Enabled = True
            RunTimer.Start()


        Else

            TimerDataUploader.Enabled = False
            btntimerstart.Text = "Start"
            statustextlab.Text = "Timer Stop at " + FormatDateTime(Now, DateFormat.ShortTime) + "."
            RunTimer.Stop()

        End If

    End Sub
End Class

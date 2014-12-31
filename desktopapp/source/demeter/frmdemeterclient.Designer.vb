<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class demeterclient
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(demeterclient))
        Me.Label1 = New System.Windows.Forms.Label()
        Me.mouseclick = New System.Windows.Forms.Label()
        Me.keyboardhit = New System.Windows.Forms.Label()
        Me.Label4 = New System.Windows.Forms.Label()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.lbmousepointer = New System.Windows.Forms.ListBox()
        Me.RunTimer = New System.Windows.Forms.Timer(Me.components)
        Me.listOpenwindows = New System.Windows.Forms.ListBox()
        Me.lblopenwinlabel = New System.Windows.Forms.Label()
        Me.btnmakescreenshot = New System.Windows.Forms.Button()
        Me.pbscreenshot = New System.Windows.Forms.PictureBox()
        Me.NotifyIcon1 = New System.Windows.Forms.NotifyIcon(Me.components)
        Me.lbltimer = New System.Windows.Forms.Label()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.Label3 = New System.Windows.Forms.Label()
        Me.lblstarttime = New System.Windows.Forms.Label()
        Me.txtreqres = New System.Windows.Forms.TextBox()
        Me.lsstats = New System.Windows.Forms.ListBox()
        Me.photoid = New System.Windows.Forms.PictureBox()
        Me.firstname = New System.Windows.Forms.Label()
        Me.MenuStrip1 = New System.Windows.Forms.MenuStrip()
        Me.FileToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.LogoutToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.ExitToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.ViewToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.LastScreenshotToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.ToolsToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.WorkDiaryToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.BillingsToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.ToolStripMenuItem2 = New System.Windows.Forms.ToolStripMenuItem()
        Me.HelpToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.AboutToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.DemeterTeamToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.KnowledgebaseToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.cbcompany = New System.Windows.Forms.ComboBox()
        Me.btntimerstart = New System.Windows.Forms.Button()
        Me.cbproject = New System.Windows.Forms.ComboBox()
        Me.Label5 = New System.Windows.Forms.Label()
        Me.Label6 = New System.Windows.Forms.Label()
        Me.Label7 = New System.Windows.Forms.Label()
        Me.cbtask = New System.Windows.Forms.ComboBox()
        Me.Label8 = New System.Windows.Forms.Label()
        Me.btnupdatenotes = New System.Windows.Forms.Button()
        Me.lblstats = New System.Windows.Forms.Label()
        Me.Label10 = New System.Windows.Forms.Label()
        Me.cbmilestone = New System.Windows.Forms.ComboBox()
        Me.Label9 = New System.Windows.Forms.Label()
        Me.Label11 = New System.Windows.Forms.Label()
        Me.txtnotes = New System.Windows.Forms.TextBox()
        Me.GroupBox1 = New System.Windows.Forms.GroupBox()
        Me.cbisfinished = New System.Windows.Forms.CheckBox()
        Me.btnset = New System.Windows.Forms.Button()
        Me.cbcompletion = New System.Windows.Forms.ComboBox()
        Me.Label12 = New System.Windows.Forms.Label()
        Me.TimerDataUploader = New System.Windows.Forms.Timer(Me.components)
        Me.TimerEventsListener = New System.Windows.Forms.Timer(Me.components)
        Me.statustext = New System.Windows.Forms.StatusStrip()
        Me.ToolStripProgressBar1 = New System.Windows.Forms.ToolStripProgressBar()
        Me.statustextlab = New System.Windows.Forms.ToolStripStatusLabel()
        Me.LastTenMinutes = New System.Windows.Forms.TextBox()
        Me.runningtime = New System.Windows.Forms.Label()
        Me.Label13 = New System.Windows.Forms.Label()
        CType(Me.pbscreenshot, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.photoid, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.MenuStrip1.SuspendLayout()
        Me.GroupBox1.SuspendLayout()
        Me.statustext.SuspendLayout()
        Me.SuspendLayout()
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Location = New System.Drawing.Point(476, 70)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(70, 13)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "Mouse Clicks"
        '
        'mouseclick
        '
        Me.mouseclick.AutoSize = True
        Me.mouseclick.Location = New System.Drawing.Point(555, 70)
        Me.mouseclick.Name = "mouseclick"
        Me.mouseclick.Size = New System.Drawing.Size(13, 13)
        Me.mouseclick.TabIndex = 1
        Me.mouseclick.Text = "0"
        '
        'keyboardhit
        '
        Me.keyboardhit.AutoSize = True
        Me.keyboardhit.Location = New System.Drawing.Point(555, 96)
        Me.keyboardhit.Name = "keyboardhit"
        Me.keyboardhit.Size = New System.Drawing.Size(13, 13)
        Me.keyboardhit.TabIndex = 3
        Me.keyboardhit.Text = "0"
        '
        'Label4
        '
        Me.Label4.AutoSize = True
        Me.Label4.Location = New System.Drawing.Point(476, 96)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(73, 13)
        Me.Label4.TabIndex = 2
        Me.Label4.Text = "Keyboard Hits"
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Location = New System.Drawing.Point(481, 144)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(64, 13)
        Me.Label2.TabIndex = 4
        Me.Label2.Text = "Logged Hits"
        '
        'lbmousepointer
        '
        Me.lbmousepointer.FormattingEnabled = True
        Me.lbmousepointer.Location = New System.Drawing.Point(481, 172)
        Me.lbmousepointer.Name = "lbmousepointer"
        Me.lbmousepointer.Size = New System.Drawing.Size(275, 134)
        Me.lbmousepointer.TabIndex = 5
        '
        'RunTimer
        '
        '
        'listOpenwindows
        '
        Me.listOpenwindows.FormattingEnabled = True
        Me.listOpenwindows.Location = New System.Drawing.Point(479, 349)
        Me.listOpenwindows.Name = "listOpenwindows"
        Me.listOpenwindows.Size = New System.Drawing.Size(277, 134)
        Me.listOpenwindows.TabIndex = 7
        '
        'lblopenwinlabel
        '
        Me.lblopenwinlabel.AutoSize = True
        Me.lblopenwinlabel.Location = New System.Drawing.Point(479, 321)
        Me.lblopenwinlabel.Name = "lblopenwinlabel"
        Me.lblopenwinlabel.Size = New System.Drawing.Size(83, 13)
        Me.lblopenwinlabel.TabIndex = 6
        Me.lblopenwinlabel.Text = "Open Windows:"
        '
        'btnmakescreenshot
        '
        Me.btnmakescreenshot.Location = New System.Drawing.Point(656, 20)
        Me.btnmakescreenshot.Name = "btnmakescreenshot"
        Me.btnmakescreenshot.Size = New System.Drawing.Size(182, 23)
        Me.btnmakescreenshot.TabIndex = 8
        Me.btnmakescreenshot.Text = "Take ScreenShot"
        Me.btnmakescreenshot.UseVisualStyleBackColor = True
        '
        'pbscreenshot
        '
        Me.pbscreenshot.Cursor = System.Windows.Forms.Cursors.Hand
        Me.pbscreenshot.Location = New System.Drawing.Point(226, 120)
        Me.pbscreenshot.MaximumSize = New System.Drawing.Size(100, 64)
        Me.pbscreenshot.Name = "pbscreenshot"
        Me.pbscreenshot.Size = New System.Drawing.Size(100, 64)
        Me.pbscreenshot.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.pbscreenshot.TabIndex = 9
        Me.pbscreenshot.TabStop = False
        '
        'NotifyIcon1
        '
        Me.NotifyIcon1.BalloonTipTitle = "Demeter Time Tracker"
        Me.NotifyIcon1.Icon = CType(resources.GetObject("NotifyIcon1.Icon"), System.Drawing.Icon)
        Me.NotifyIcon1.Text = "Demeter Time Tracker"
        Me.NotifyIcon1.Visible = True
        '
        'lbltimer
        '
        Me.lbltimer.AutoSize = True
        Me.lbltimer.Location = New System.Drawing.Point(707, 502)
        Me.lbltimer.Name = "lbltimer"
        Me.lbltimer.Size = New System.Drawing.Size(34, 13)
        Me.lbltimer.TabIndex = 10
        Me.lbltimer.Text = "00:00"
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(694, 518)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(128, 23)
        Me.Button1.TabIndex = 11
        Me.Button1.Text = "Upload"
        Me.Button1.UseVisualStyleBackColor = True
        '
        'Label3
        '
        Me.Label3.AutoSize = True
        Me.Label3.Location = New System.Drawing.Point(226, 103)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(96, 13)
        Me.Label3.TabIndex = 12
        Me.Label3.Text = "Last Image Taken:"
        '
        'lblstarttime
        '
        Me.lblstarttime.AutoSize = True
        Me.lblstarttime.Location = New System.Drawing.Point(654, 69)
        Me.lblstarttime.Name = "lblstarttime"
        Me.lblstarttime.Size = New System.Drawing.Size(89, 13)
        Me.lblstarttime.TabIndex = 13
        Me.lblstarttime.Text = "mm/dd/yy hh:mm"
        '
        'txtreqres
        '
        Me.txtreqres.Location = New System.Drawing.Point(798, 163)
        Me.txtreqres.Multiline = True
        Me.txtreqres.Name = "txtreqres"
        Me.txtreqres.Size = New System.Drawing.Size(283, 40)
        Me.txtreqres.TabIndex = 14
        '
        'lsstats
        '
        Me.lsstats.FormattingEnabled = True
        Me.lsstats.Location = New System.Drawing.Point(798, 209)
        Me.lsstats.Name = "lsstats"
        Me.lsstats.Size = New System.Drawing.Size(433, 160)
        Me.lsstats.TabIndex = 15
        '
        'photoid
        '
        Me.photoid.Location = New System.Drawing.Point(12, 34)
        Me.photoid.Name = "photoid"
        Me.photoid.Size = New System.Drawing.Size(45, 58)
        Me.photoid.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.photoid.TabIndex = 16
        Me.photoid.TabStop = False
        '
        'firstname
        '
        Me.firstname.AutoSize = True
        Me.firstname.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.firstname.Location = New System.Drawing.Point(63, 34)
        Me.firstname.Name = "firstname"
        Me.firstname.Size = New System.Drawing.Size(71, 16)
        Me.firstname.TabIndex = 17
        Me.firstname.Text = "firstname"
        '
        'MenuStrip1
        '
        Me.MenuStrip1.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.FileToolStripMenuItem, Me.ViewToolStripMenuItem, Me.ToolsToolStripMenuItem, Me.HelpToolStripMenuItem})
        Me.MenuStrip1.Location = New System.Drawing.Point(0, 0)
        Me.MenuStrip1.Name = "MenuStrip1"
        Me.MenuStrip1.Size = New System.Drawing.Size(1076, 24)
        Me.MenuStrip1.TabIndex = 18
        Me.MenuStrip1.Text = "MenuStrip1"
        '
        'FileToolStripMenuItem
        '
        Me.FileToolStripMenuItem.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.LogoutToolStripMenuItem, Me.ExitToolStripMenuItem})
        Me.FileToolStripMenuItem.Name = "FileToolStripMenuItem"
        Me.FileToolStripMenuItem.Size = New System.Drawing.Size(51, 20)
        Me.FileToolStripMenuItem.Text = "&Status"
        '
        'LogoutToolStripMenuItem
        '
        Me.LogoutToolStripMenuItem.Name = "LogoutToolStripMenuItem"
        Me.LogoutToolStripMenuItem.Size = New System.Drawing.Size(120, 22)
        Me.LogoutToolStripMenuItem.Text = "&Sign-out"
        '
        'ExitToolStripMenuItem
        '
        Me.ExitToolStripMenuItem.Name = "ExitToolStripMenuItem"
        Me.ExitToolStripMenuItem.Size = New System.Drawing.Size(120, 22)
        Me.ExitToolStripMenuItem.Text = "E&xit"
        '
        'ViewToolStripMenuItem
        '
        Me.ViewToolStripMenuItem.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.LastScreenshotToolStripMenuItem})
        Me.ViewToolStripMenuItem.Name = "ViewToolStripMenuItem"
        Me.ViewToolStripMenuItem.Size = New System.Drawing.Size(44, 20)
        Me.ViewToolStripMenuItem.Text = "&View"
        '
        'LastScreenshotToolStripMenuItem
        '
        Me.LastScreenshotToolStripMenuItem.Name = "LastScreenshotToolStripMenuItem"
        Me.LastScreenshotToolStripMenuItem.Size = New System.Drawing.Size(156, 22)
        Me.LastScreenshotToolStripMenuItem.Text = "Last S&creenshot"
        '
        'ToolsToolStripMenuItem
        '
        Me.ToolsToolStripMenuItem.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.WorkDiaryToolStripMenuItem, Me.BillingsToolStripMenuItem, Me.ToolStripMenuItem2})
        Me.ToolsToolStripMenuItem.Name = "ToolsToolStripMenuItem"
        Me.ToolsToolStripMenuItem.Size = New System.Drawing.Size(48, 20)
        Me.ToolsToolStripMenuItem.Text = "&Tools"
        '
        'WorkDiaryToolStripMenuItem
        '
        Me.WorkDiaryToolStripMenuItem.Name = "WorkDiaryToolStripMenuItem"
        Me.WorkDiaryToolStripMenuItem.Size = New System.Drawing.Size(135, 22)
        Me.WorkDiaryToolStripMenuItem.Text = "&Work Diary"
        '
        'BillingsToolStripMenuItem
        '
        Me.BillingsToolStripMenuItem.Name = "BillingsToolStripMenuItem"
        Me.BillingsToolStripMenuItem.Size = New System.Drawing.Size(135, 22)
        Me.BillingsToolStripMenuItem.Text = "&Billings"
        '
        'ToolStripMenuItem2
        '
        Me.ToolStripMenuItem2.Name = "ToolStripMenuItem2"
        Me.ToolStripMenuItem2.Size = New System.Drawing.Size(135, 22)
        Me.ToolStripMenuItem2.Text = "&Preferences"
        '
        'HelpToolStripMenuItem
        '
        Me.HelpToolStripMenuItem.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.AboutToolStripMenuItem, Me.DemeterTeamToolStripMenuItem, Me.KnowledgebaseToolStripMenuItem})
        Me.HelpToolStripMenuItem.Name = "HelpToolStripMenuItem"
        Me.HelpToolStripMenuItem.Size = New System.Drawing.Size(44, 20)
        Me.HelpToolStripMenuItem.Text = "&Help"
        '
        'AboutToolStripMenuItem
        '
        Me.AboutToolStripMenuItem.Name = "AboutToolStripMenuItem"
        Me.AboutToolStripMenuItem.Size = New System.Drawing.Size(157, 22)
        Me.AboutToolStripMenuItem.Text = "A&bout"
        '
        'DemeterTeamToolStripMenuItem
        '
        Me.DemeterTeamToolStripMenuItem.Name = "DemeterTeamToolStripMenuItem"
        Me.DemeterTeamToolStripMenuItem.Size = New System.Drawing.Size(157, 22)
        Me.DemeterTeamToolStripMenuItem.Text = "D&emeter Team"
        '
        'KnowledgebaseToolStripMenuItem
        '
        Me.KnowledgebaseToolStripMenuItem.Name = "KnowledgebaseToolStripMenuItem"
        Me.KnowledgebaseToolStripMenuItem.Size = New System.Drawing.Size(157, 22)
        Me.KnowledgebaseToolStripMenuItem.Text = "&Knowledgebase"
        '
        'cbcompany
        '
        Me.cbcompany.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbcompany.FormattingEnabled = True
        Me.cbcompany.Location = New System.Drawing.Point(10, 120)
        Me.cbcompany.Name = "cbcompany"
        Me.cbcompany.Size = New System.Drawing.Size(209, 21)
        Me.cbcompany.TabIndex = 19
        '
        'btntimerstart
        '
        Me.btntimerstart.Location = New System.Drawing.Point(229, 190)
        Me.btntimerstart.Name = "btntimerstart"
        Me.btntimerstart.Size = New System.Drawing.Size(97, 27)
        Me.btntimerstart.TabIndex = 20
        Me.btntimerstart.Text = "Start"
        Me.btntimerstart.UseVisualStyleBackColor = True
        '
        'cbproject
        '
        Me.cbproject.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbproject.FormattingEnabled = True
        Me.cbproject.Location = New System.Drawing.Point(12, 170)
        Me.cbproject.Name = "cbproject"
        Me.cbproject.Size = New System.Drawing.Size(207, 21)
        Me.cbproject.TabIndex = 21
        '
        'Label5
        '
        Me.Label5.AutoSize = True
        Me.Label5.Location = New System.Drawing.Point(12, 103)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(84, 13)
        Me.Label5.TabIndex = 22
        Me.Label5.Text = "Select Company"
        '
        'Label6
        '
        Me.Label6.AutoSize = True
        Me.Label6.Location = New System.Drawing.Point(12, 149)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(73, 13)
        Me.Label6.TabIndex = 23
        Me.Label6.Text = "Select Project"
        '
        'Label7
        '
        Me.Label7.AutoSize = True
        Me.Label7.Location = New System.Drawing.Point(12, 260)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(127, 13)
        Me.Label7.TabIndex = 24
        Me.Label7.Text = "Track my time to this task"
        '
        'cbtask
        '
        Me.cbtask.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbtask.FormattingEnabled = True
        Me.cbtask.Location = New System.Drawing.Point(14, 278)
        Me.cbtask.Name = "cbtask"
        Me.cbtask.Size = New System.Drawing.Size(207, 21)
        Me.cbtask.TabIndex = 25
        '
        'Label8
        '
        Me.Label8.AutoSize = True
        Me.Label8.Location = New System.Drawing.Point(226, 226)
        Me.Label8.Name = "Label8"
        Me.Label8.Size = New System.Drawing.Size(104, 13)
        Me.Label8.TabIndex = 26
        Me.Label8.Text = "Time tracking is OFF"
        '
        'btnupdatenotes
        '
        Me.btnupdatenotes.Location = New System.Drawing.Point(255, 517)
        Me.btnupdatenotes.Name = "btnupdatenotes"
        Me.btnupdatenotes.Size = New System.Drawing.Size(75, 24)
        Me.btnupdatenotes.TabIndex = 29
        Me.btnupdatenotes.Text = "Save Notes"
        Me.btnupdatenotes.UseVisualStyleBackColor = True
        Me.btnupdatenotes.Visible = False
        '
        'lblstats
        '
        Me.lblstats.AutoSize = True
        Me.lblstats.Location = New System.Drawing.Point(579, 567)
        Me.lblstats.Name = "lblstats"
        Me.lblstats.Size = New System.Drawing.Size(10, 13)
        Me.lblstats.TabIndex = 31
        Me.lblstats.Text = "-"
        Me.lblstats.Visible = False
        '
        'Label10
        '
        Me.Label10.AutoSize = True
        Me.Label10.Location = New System.Drawing.Point(476, 567)
        Me.Label10.Name = "Label10"
        Me.Label10.Size = New System.Drawing.Size(86, 13)
        Me.Label10.TabIndex = 30
        Me.Label10.Text = "Network Status: "
        Me.Label10.Visible = False
        '
        'cbmilestone
        '
        Me.cbmilestone.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbmilestone.FormattingEnabled = True
        Me.cbmilestone.Location = New System.Drawing.Point(13, 223)
        Me.cbmilestone.Name = "cbmilestone"
        Me.cbmilestone.Size = New System.Drawing.Size(207, 21)
        Me.cbmilestone.TabIndex = 33
        '
        'Label9
        '
        Me.Label9.AutoSize = True
        Me.Label9.Location = New System.Drawing.Point(11, 205)
        Me.Label9.Name = "Label9"
        Me.Label9.Size = New System.Drawing.Size(85, 13)
        Me.Label9.TabIndex = 32
        Me.Label9.Text = "Select Milestone"
        '
        'Label11
        '
        Me.Label11.AutoSize = True
        Me.Label11.Location = New System.Drawing.Point(16, 334)
        Me.Label11.Name = "Label11"
        Me.Label11.Size = New System.Drawing.Size(176, 13)
        Me.Label11.TabIndex = 34
        Me.Label11.Text = "Describe what you are working now"
        '
        'txtnotes
        '
        Me.txtnotes.Location = New System.Drawing.Point(15, 351)
        Me.txtnotes.Multiline = True
        Me.txtnotes.Name = "txtnotes"
        Me.txtnotes.Size = New System.Drawing.Size(311, 153)
        Me.txtnotes.TabIndex = 35
        '
        'GroupBox1
        '
        Me.GroupBox1.Controls.Add(Me.cbisfinished)
        Me.GroupBox1.Controls.Add(Me.btnset)
        Me.GroupBox1.Controls.Add(Me.cbcompletion)
        Me.GroupBox1.Controls.Add(Me.Label12)
        Me.GroupBox1.Location = New System.Drawing.Point(230, 242)
        Me.GroupBox1.Name = "GroupBox1"
        Me.GroupBox1.Size = New System.Drawing.Size(96, 103)
        Me.GroupBox1.TabIndex = 36
        Me.GroupBox1.TabStop = False
        '
        'cbisfinished
        '
        Me.cbisfinished.AutoSize = True
        Me.cbisfinished.BackColor = System.Drawing.Color.Transparent
        Me.cbisfinished.Location = New System.Drawing.Point(7, 56)
        Me.cbisfinished.Name = "cbisfinished"
        Me.cbisfinished.Size = New System.Drawing.Size(87, 17)
        Me.cbisfinished.TabIndex = 3
        Me.cbisfinished.Text = "Is it finished?"
        Me.cbisfinished.UseVisualStyleBackColor = False
        '
        'btnset
        '
        Me.btnset.Enabled = False
        Me.btnset.Location = New System.Drawing.Point(55, 76)
        Me.btnset.Name = "btnset"
        Me.btnset.Size = New System.Drawing.Size(35, 23)
        Me.btnset.TabIndex = 2
        Me.btnset.Text = "Set"
        Me.btnset.UseVisualStyleBackColor = True
        '
        'cbcompletion
        '
        Me.cbcompletion.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbcompletion.FormattingEnabled = True
        Me.cbcompletion.Items.AddRange(New Object() {"0", "10", "20", "30", "40", "50", "60", "70", "80", "90"})
        Me.cbcompletion.Location = New System.Drawing.Point(6, 31)
        Me.cbcompletion.Name = "cbcompletion"
        Me.cbcompletion.Size = New System.Drawing.Size(85, 21)
        Me.cbcompletion.TabIndex = 1
        '
        'Label12
        '
        Me.Label12.AutoSize = True
        Me.Label12.BackColor = System.Drawing.Color.Transparent
        Me.Label12.FlatStyle = System.Windows.Forms.FlatStyle.Flat
        Me.Label12.Location = New System.Drawing.Point(1, 10)
        Me.Label12.Name = "Label12"
        Me.Label12.Size = New System.Drawing.Size(95, 13)
        Me.Label12.TabIndex = 0
        Me.Label12.Text = "Set Completion (%)"
        '
        'TimerDataUploader
        '
        Me.TimerDataUploader.Interval = 1000
        '
        'TimerEventsListener
        '
        Me.TimerEventsListener.Enabled = True
        '
        'statustext
        '
        Me.statustext.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.ToolStripProgressBar1, Me.statustextlab})
        Me.statustext.Location = New System.Drawing.Point(0, 567)
        Me.statustext.Name = "statustext"
        Me.statustext.Size = New System.Drawing.Size(1076, 22)
        Me.statustext.TabIndex = 37
        '
        'ToolStripProgressBar1
        '
        Me.ToolStripProgressBar1.Name = "ToolStripProgressBar1"
        Me.ToolStripProgressBar1.Size = New System.Drawing.Size(50, 16)
        '
        'statustextlab
        '
        Me.statustextlab.BackColor = System.Drawing.Color.Transparent
        Me.statustextlab.Name = "statustextlab"
        Me.statustextlab.Size = New System.Drawing.Size(63, 17)
        Me.statustextlab.Text = "Last event:"
        '
        'LastTenMinutes
        '
        Me.LastTenMinutes.Location = New System.Drawing.Point(479, 544)
        Me.LastTenMinutes.Name = "LastTenMinutes"
        Me.LastTenMinutes.Size = New System.Drawing.Size(20, 20)
        Me.LastTenMinutes.TabIndex = 38
        '
        'runningtime
        '
        Me.runningtime.AutoSize = True
        Me.runningtime.BackColor = System.Drawing.Color.Transparent
        Me.runningtime.Font = New System.Drawing.Font("Microsoft Sans Serif", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.runningtime.Location = New System.Drawing.Point(11, 521)
        Me.runningtime.Name = "runningtime"
        Me.runningtime.Size = New System.Drawing.Size(96, 25)
        Me.runningtime.TabIndex = 39
        Me.runningtime.Text = "00:00:00"
        '
        'Label13
        '
        Me.Label13.AutoSize = True
        Me.Label13.Location = New System.Drawing.Point(16, 510)
        Me.Label13.Name = "Label13"
        Me.Label13.Size = New System.Drawing.Size(80, 13)
        Me.Label13.TabIndex = 40
        Me.Label13.Text = "Recorded Time"
        '
        'demeterclient
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.BackColor = System.Drawing.SystemColors.ControlLightLight
        Me.ClientSize = New System.Drawing.Size(1076, 589)
        Me.Controls.Add(Me.Label13)
        Me.Controls.Add(Me.runningtime)
        Me.Controls.Add(Me.LastTenMinutes)
        Me.Controls.Add(Me.statustext)
        Me.Controls.Add(Me.GroupBox1)
        Me.Controls.Add(Me.txtnotes)
        Me.Controls.Add(Me.Label11)
        Me.Controls.Add(Me.cbmilestone)
        Me.Controls.Add(Me.Label9)
        Me.Controls.Add(Me.lblstats)
        Me.Controls.Add(Me.Label10)
        Me.Controls.Add(Me.btnupdatenotes)
        Me.Controls.Add(Me.Label8)
        Me.Controls.Add(Me.cbtask)
        Me.Controls.Add(Me.Label7)
        Me.Controls.Add(Me.Label6)
        Me.Controls.Add(Me.Label5)
        Me.Controls.Add(Me.cbproject)
        Me.Controls.Add(Me.btntimerstart)
        Me.Controls.Add(Me.cbcompany)
        Me.Controls.Add(Me.firstname)
        Me.Controls.Add(Me.photoid)
        Me.Controls.Add(Me.lsstats)
        Me.Controls.Add(Me.txtreqres)
        Me.Controls.Add(Me.lblstarttime)
        Me.Controls.Add(Me.Label3)
        Me.Controls.Add(Me.Button1)
        Me.Controls.Add(Me.lbltimer)
        Me.Controls.Add(Me.pbscreenshot)
        Me.Controls.Add(Me.btnmakescreenshot)
        Me.Controls.Add(Me.listOpenwindows)
        Me.Controls.Add(Me.lblopenwinlabel)
        Me.Controls.Add(Me.lbmousepointer)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.keyboardhit)
        Me.Controls.Add(Me.Label4)
        Me.Controls.Add(Me.mouseclick)
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.MenuStrip1)
        Me.Icon = CType(resources.GetObject("$this.Icon"), System.Drawing.Icon)
        Me.MainMenuStrip = Me.MenuStrip1
        Me.MaximizeBox = False
        Me.Name = "demeterclient"
        Me.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen
        Me.Text = " "
        CType(Me.pbscreenshot, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.photoid, System.ComponentModel.ISupportInitialize).EndInit()
        Me.MenuStrip1.ResumeLayout(False)
        Me.MenuStrip1.PerformLayout()
        Me.GroupBox1.ResumeLayout(False)
        Me.GroupBox1.PerformLayout()
        Me.statustext.ResumeLayout(False)
        Me.statustext.PerformLayout()
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Shadows WithEvents mouseclick As System.Windows.Forms.Label
    Friend WithEvents keyboardhit As System.Windows.Forms.Label
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents lbmousepointer As System.Windows.Forms.ListBox
    Friend WithEvents RunTimer As System.Windows.Forms.Timer
    Friend WithEvents listOpenwindows As System.Windows.Forms.ListBox
    Friend WithEvents lblopenwinlabel As System.Windows.Forms.Label
    Friend WithEvents btnmakescreenshot As System.Windows.Forms.Button
    Friend WithEvents pbscreenshot As System.Windows.Forms.PictureBox
    Friend WithEvents NotifyIcon1 As System.Windows.Forms.NotifyIcon
    Friend WithEvents lbltimer As System.Windows.Forms.Label
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents lblstarttime As System.Windows.Forms.Label
    Friend WithEvents txtreqres As System.Windows.Forms.TextBox
    Friend WithEvents lsstats As System.Windows.Forms.ListBox
    Friend WithEvents photoid As System.Windows.Forms.PictureBox
    Friend WithEvents firstname As System.Windows.Forms.Label
    Friend WithEvents MenuStrip1 As System.Windows.Forms.MenuStrip
    Friend WithEvents FileToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents LogoutToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ExitToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ViewToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents LastScreenshotToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ToolsToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents WorkDiaryToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents BillingsToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ToolStripMenuItem2 As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents HelpToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents AboutToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents DemeterTeamToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents KnowledgebaseToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents cbcompany As System.Windows.Forms.ComboBox
    Friend WithEvents btntimerstart As System.Windows.Forms.Button
    Friend WithEvents cbproject As System.Windows.Forms.ComboBox
    Friend WithEvents Label5 As System.Windows.Forms.Label
    Friend WithEvents Label6 As System.Windows.Forms.Label
    Friend WithEvents Label7 As System.Windows.Forms.Label
    Friend WithEvents cbtask As System.Windows.Forms.ComboBox
    Friend WithEvents Label8 As System.Windows.Forms.Label
    Friend WithEvents btnupdatenotes As System.Windows.Forms.Button
    Friend WithEvents lblstats As System.Windows.Forms.Label
    Friend WithEvents Label10 As System.Windows.Forms.Label
    Friend WithEvents cbmilestone As System.Windows.Forms.ComboBox
    Friend WithEvents Label9 As System.Windows.Forms.Label
    Friend WithEvents Label11 As System.Windows.Forms.Label
    Friend WithEvents txtnotes As System.Windows.Forms.TextBox
    Friend WithEvents GroupBox1 As System.Windows.Forms.GroupBox
    Friend WithEvents cbisfinished As System.Windows.Forms.CheckBox
    Friend WithEvents btnset As System.Windows.Forms.Button
    Friend WithEvents cbcompletion As System.Windows.Forms.ComboBox
    Friend WithEvents Label12 As System.Windows.Forms.Label
    Friend WithEvents TimerDataUploader As System.Windows.Forms.Timer
    Friend WithEvents TimerEventsListener As System.Windows.Forms.Timer
    Friend WithEvents statustext As System.Windows.Forms.StatusStrip
    Friend WithEvents statustextlab As System.Windows.Forms.ToolStripStatusLabel
    Friend WithEvents LastTenMinutes As System.Windows.Forms.TextBox
    Friend WithEvents ToolStripProgressBar1 As System.Windows.Forms.ToolStripProgressBar
    Friend WithEvents runningtime As System.Windows.Forms.Label
    Friend WithEvents Label13 As System.Windows.Forms.Label

End Class

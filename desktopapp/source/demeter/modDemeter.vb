Imports System.Text

Module modDemeter
    Public path As String = ""
    Public DOMAIN As String = "http://demeter.centraleffects.com/"
    'declare user information 
    Structure USER_FIELDS
        Dim firstname As String
        Dim lastname As String
        Dim username As String
        Dim email As String
        Dim photoid As String
        Dim id As String
        Dim last_screenshot As String
    End Structure

    Public USER_INFO As USER_FIELDS
    Public CONNECTION_ACTIVE As Boolean = False
    Public LAST_SCREENSHOT As String
    Public LIST_COMPANIES As String()
    Public LIST_COMPANIES_INDEX As New List(Of String)
    Public LIST_PROJECTS As String()
    Public LIST_PROJECTS_INDEX As New List(Of String)
    Public LIST_MILESTONE As String()
    Public LIST_MILESTONE_INDEX As New List(Of String)
    Public LIST_TASK As String()
    Public LIST_TASK_INDEX As New List(Of String)
    Public LIST_TASK_COMPLETION_INDEX As New List(Of String)
    Public IS_RUNNING As Boolean = False
    Public TenMinutes As Integer
    Public RANDOM_STRING As String
    Public RANDOM_STRING_SCREENSHOT As Integer
    Public LAST_SCREENSHOT_FOR_UPLOAD As String = ""
    Public TIME_STARTED As DateTime
    Public RUNNING_TIME As Integer = 0
    Dim rng As Random = New Random
    Function RANDOM_NUMBERS_FOR_SCREENSHOT()
        Return CInt(Math.Ceiling(Rnd() * 10))
    End Function
    Function GENERATE_RANDOM_NUMBER()
        Dim sb As New StringBuilder

        ' Selection of pure numbers sequence or mixed one
        Dim pureNumbers = rng.Next(1, 11)
        If pureNumbers < 7 Then
            ' Generate a sequence of only digits
            Dim number As Integer = rng.Next(1, 1000000)
            Dim digits As String = number.ToString("000000")
            For i As Integer = 1 To 6
                Dim idx As Integer = rng.Next(0, digits.Length)
                sb.Append(digits.Substring(idx, 1))
            Next
        Else
            ' Generate a sequence of digits and letters 
            Dim s As String = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"
            For i As Integer = 1 To 6
                Dim idx As Integer = rng.Next(0, 36)
                sb.Append(s.Substring(idx, 1))
            Next
        End If
        Return DateTime.Now.ToString("yyyyMMddHHmmss") + USER_INFO.id + sb.ToString()
    End Function
End Module

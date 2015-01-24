REM Parses a 5 column csv into a JSON file
REM Source: http://stackoverflow.com/questions/21921051/how-to-parse-a-csv-file-using-batch-script

@setlocal enableextensions enabledelayedexpansion
@ECHO OFF
for /f "tokens=1,2,3,4 delims=/- " %%w in ('echo %date%') do (
set weekday=%%w
set month=%%x
set day=%%y
set year=%%z
)

set json_file="\path\to\target.json"
set log_file="\path\to\source.csv"

set json={ [

FOR /F "tokens=1,2,3,4,5* delims=,-" %%a in (%log_file%) do (
set json=!json! { "0" : "%%a", "1" : "%%b", "2" : "%%c" , "3" : "%%d" , "4" : "%%e" },
)
set json=!json:~0,-1!
set json=%json% ] }

echo %json% > %json_file%

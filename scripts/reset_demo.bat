@echo off
REM Ensure XAMPP’s MySQL client is callable
set "PATH=C:\xampp\mysql\bin;%PATH%"

REM Change to your project folder
cd /d "C:\xampp\htdocs\demo_system"

REM Run the CI CLI reset and log output in the project
"C:\xampp\php\php.exe" index.php tools reset_demo >> "C:\xampp\htdocs\demo_system\reset_demo.log" 2>&1
 
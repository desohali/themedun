<?php
echo getcwd();

if (unlink(getcwd()."/fotoprofesional/48BC92BD53DC7A.jpg")) {
  # code...
  echo "success";
} else {
  # code...
  echo "error";
}

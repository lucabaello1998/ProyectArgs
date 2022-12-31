<?php
include("../db.php");
if(isset($_POST['sap_lz']))
{
  $htmls = '';
  $sap = $_POST['sap_lz'];
  
  $s = mysqli_query($conn,"SELECT * FROM basemateriales WHERE sap LIKE '%$sap%' LIMIT 10");
  if(mysqli_num_rows($s) > 0)
  {
    while ($ros = mysqli_fetch_assoc($s))
    {
      $htmls .= '<div><a class="suggest-sap_lz" data="'.$ros['sap'].'" mate="'.$ros['material'].'" id="sap">'.$ros['sap'].'</a></div>';
    }
  }
  echo $htmls;
}
if(isset($_POST['mat_lz']))
{
  $htmlm = '';
  $mat = $_POST['mat_lz'];
  
  $m = mysqli_query($conn,"SELECT * FROM basemateriales WHERE material LIKE '%$mat%' LIMIT 10");
  if(mysqli_num_rows($m) > 0)
  {
    while ($rom = mysqli_fetch_assoc($m))
    {
      $htmlm .= '<div><a class="suggest-mat_lz" data="'.$rom['material'].'" sapi="'.$rom['sap'].'" id="mat">'.$rom['material'].'</a></div>';
    }
  }
  echo $htmlm;
}

if(isset($_POST['sap_jls']))
{
  $htmls = '';
  $sap = $_POST['sap_jls'];
  
  $s = mysqli_query($conn,"SELECT * FROM basemateriales WHERE sap LIKE '%$sap%' LIMIT 10");
  if(mysqli_num_rows($s) > 0)
  {
    while ($ros = mysqli_fetch_assoc($s))
    {
      $htmls .= '<div><a class="suggest-sap_jls" data="'.$ros['sap'].'" mate="'.$ros['material'].'" id="sap">'.$ros['sap'].'</a></div>';
    }
  }
  echo $htmls;
}
if(isset($_POST['mat_jls']))
{
  $htmlm = '';
  $mat = $_POST['mat_jls'];
  
  $m = mysqli_query($conn,"SELECT * FROM basemateriales WHERE material LIKE '%$mat%' LIMIT 10");
  if(mysqli_num_rows($m) > 0)
  {
    while ($rom = mysqli_fetch_assoc($m))
    {
      $htmlm .= '<div><a class="suggest-mat_jls" data="'.$rom['material'].'" sapi="'.$rom['sap'].'" id="mat">'.$rom['material'].'</a></div>';
    }
  }
  echo $htmlm;
}

if(isset($_POST['sap_sn']))
{
  $htmls = '';
  $sap = $_POST['sap_sn'];
  
  $s = mysqli_query($conn,"SELECT * FROM basemateriales WHERE sap LIKE '%$sap%' LIMIT 10");
  if(mysqli_num_rows($s) > 0)
  {
    while ($ros = mysqli_fetch_assoc($s))
    {
      $htmls .= '<div><a class="suggest-sap_sn" data="'.$ros['sap'].'" mate="'.$ros['material'].'" id="sap">'.$ros['sap'].'</a></div>';
    }
  }
  echo $htmls;
}
if(isset($_POST['mat_sn']))
{
  $htmlm = '';
  $mat = $_POST['mat_sn'];
  
  $m = mysqli_query($conn,"SELECT * FROM basemateriales WHERE material LIKE '%$mat%' LIMIT 10");
  if(mysqli_num_rows($m) > 0)
  {
    while ($rom = mysqli_fetch_assoc($m))
    {
      $htmlm .= '<div><a class="suggest-mat_sn" data="'.$rom['material'].'" sapi="'.$rom['sap'].'" id="mat">'.$rom['material'].'</a></div>';
    }
  }
  echo $htmlm;
}
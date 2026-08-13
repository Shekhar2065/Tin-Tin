<?php
declare(strict_types=1);
require __DIR__.'/includes/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Method not allowed'); }
$source = $_POST['source'] ?? 'budget';
$return = $source === 'contact' ? 'contact.php' : 'budget-plan.php';
if (!empty($_POST['website_check'])) { header('Location: '.url($return.'?success=1')); exit; }
function field(string $key): string { return trim((string)($_POST[$key] ?? '')); }
$fullName=field('full_name');$email=field('email');
if ($fullName==='' || !filter_var($email,FILTER_VALIDATE_EMAIL)) { header('Location: '.url($return.'?error=validation')); exit; }
$phone=field('phone');$whatsapp=field('whatsapp');$country=field('country');$trek=field('trek') ?: 'General contact';
$travelMonth=field('travel_month');$travelDates=field('travel_dates');$flexible=isset($_POST['flexible_dates'])?'Yes':'No';$groupSize=max(1,(int)($_POST['group_size']??1));$groupType=field('group_type');
$experience=field('trekking_experience');$fitness=field('fitness_level');$altitude=field('altitude_experience');$health=field('additional_health_notes');$accommodation=field('accommodation');$hotel=field('hotel_level');$room=field('room_type');
$interests=is_array($_POST['interests']??null)?implode(', ',array_map('trim',$_POST['interests'])):'';$budget=field('budget_range');$notes=field('additional_notes');
if(field('preferred_contact')!==''){$notes=trim($notes."\nPreferred contact: ".field('preferred_contact'));}
try{
  $db=db();$stmt=$db->prepare('INSERT INTO inquiries (full_name,email,phone,whatsapp,country,trek,travel_month,travel_dates,flexible_dates,group_size,group_type,trekking_experience,fitness_level,altitude_experience,additional_health_notes,accommodation,hotel_level,room_type,interests,budget_range,additional_notes) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
  $stmt->bind_param('sssssssssisssssssssss',$fullName,$email,$phone,$whatsapp,$country,$trek,$travelMonth,$travelDates,$flexible,$groupSize,$groupType,$experience,$fitness,$altitude,$health,$accommodation,$hotel,$room,$interests,$budget,$notes);$stmt->execute();
  header('Location: '.url($return.'?success=1'));exit;
}catch(Throwable $error){error_log('Inquiry save failed: '.$error->getMessage());header('Location: '.url($return.'?error=database'));exit;}

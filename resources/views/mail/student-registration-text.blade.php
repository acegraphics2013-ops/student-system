Student Registration

Name: {{ $name }}
@if ($email !== '')
Email: {{ $email }}
@endif
@if ($course !== '')
Course: {{ $course }}
@endif
@if ($yearLevel !== '')
Year Level: {{ $yearLevel }}
@endif

@if ($email !== '')
You can reply directly to this email to contact the student.
@endif

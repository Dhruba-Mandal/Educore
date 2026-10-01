<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $course->course_name }}</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .container {
            width: 95%;
            max-width: 1100px;
            margin: 40px auto;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .top h1 {
            font-size: 28px;
            margin-bottom: 6px;
        }

        .top p {
            color: #6b7280;
            font-size: 14px;
        }

        .buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 9px 15px;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            font-size: 13px;
            font-weight: 600;
        }

        .back-btn {
            background: #6b7280;
        }

        .edit-btn {
            background: #2563eb;
        }

        .details-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .details-card h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .detail {
            padding: 15px;
            background: #f8fafc;
            border-radius: 7px;
        }

        .detail-label {
            display: block;
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .detail-value {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
        }

        .active {
            color: #166534;
        }

        .inactive {
            color: #991b1b;
        }

        .semester-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .semester-section h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .semester-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .semester {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 18px;
            background: #fafafa;
        }

        .semester h3 {
            font-size: 16px;
            margin-bottom: 12px;
        }

        .subjects {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .subject {
            background: #eef2ff;
            color: #3730a3;
            padding: 7px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
        }

        .no-subject {
            color: #9ca3af;
            font-size: 13px;
        }

        @media (max-width: 700px) {

            .top {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .details-grid,
            .semester-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="container">

    {{-- HEADER --}}
    <div class="top">

        <div>
            <h1>{{ $course->course_name }}</h1>

            <p>
                Course Details
            </p>
        </div>

        <div class="buttons">

            <a
                href="{{ route('admin.courses.index') }}"
                class="btn back-btn"
            >
                ← Back
            </a>

            <a
                href="{{ route('admin.courses.edit', $course->id) }}"
                class="btn edit-btn"
            >
                Edit Course
            </a>

        </div>

    </div>


    {{-- COURSE INFORMATION --}}
    <div class="details-card">

        <h2>Course Information</h2>

        <div class="details-grid">

            <div class="detail">

                <span class="detail-label">
                    Course ID
                </span>

                <span class="detail-value">
                    {{ $course->id }}
                </span>

            </div>


            <div class="detail">

                <span class="detail-label">
                    Department
                </span>

                <span class="detail-value">
                    {{ $course->department->department_name ?? 'N/A' }}
                </span>

            </div>


            <div class="detail">

                <span class="detail-label">
                    Course Code
                </span>

                <span class="detail-value">
                    {{ $course->course_code }}
                </span>

            </div>


            <div class="detail">

                <span class="detail-label">
                    Course Name
                </span>

                <span class="detail-value">
                    {{ $course->course_name }}
                </span>

            </div>


            <div class="detail">

                <span class="detail-label">
                    Duration
                </span>

                <span class="detail-value">

                    {{ $course->duration_years }}

                    {{ $course->duration_years == 1 ? 'Year' : 'Years' }}

                </span>

            </div>


            <div class="detail">

                <span class="detail-label">
                    Status
                </span>

                @if($course->status)

                    <span class="detail-value active">
                        Active
                    </span>

                @else

                    <span class="detail-value inactive">
                        Inactive
                    </span>

                @endif

            </div>

        </div>

    </div>


    {{-- SEMESTER SUBJECTS --}}
    <div class="semester-section">

        <h2>Semester-wise Subjects</h2>

        @php
            $totalSemesters = $course->duration_years * 2;
        @endphp

        <div class="semester-grid">

            @for($i = 1; $i <= $totalSemesters; $i++)

                <div class="semester">

                    <h3>
                        Semester {{ $i }}
                    </h3>

                    @php
                        $subjectIds = $course->{'semester_'.$i} ?? [];
                    @endphp

                    @if(count($subjectIds) > 0)

                        <div class="subjects">

                            @foreach($subjectIds as $subjectId)

                                @php
                                    $subject = \App\Models\Subject::find($subjectId);
                                @endphp

                                @if($subject)

                                    <span class="subject">
                                        {{ $subject->subject_name }}
                                    </span>

                                @endif

                            @endforeach

                        </div>

                    @else

                        <span class="no-subject">
                            No subjects assigned
                        </span>

                    @endif

                </div>

            @endfor

        </div>

    </div>

</div>

</body>
</html>
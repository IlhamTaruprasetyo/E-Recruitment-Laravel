<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Models\Department;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobApiController extends Controller
{
    /**
     * Display a listing of active open jobs with filters and pagination.
     * Accessible by Next.js and Nuxt.js.
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search') ?? $request->query('q');
        $location = $request->query('location');
        $departmentId = $request->query('department_id');
        $departmentName = $request->query('department');
        $companyId = $request->query('company_id');
        $employmentType = $request->query('employment_type') ?? $request->query('type');
        $perPage = min(50, max(1, (int) ($request->query('per_page') ?? $request->query('limit') ?? 10)));

        // Selalu gunakan scope active (status = 'Open' dan deadline >= today)
        $jobsQuery = Job::active()->with(['company', 'department', 'position', 'degrees', 'majors']);

        // 1. Filter Pencarian Text
        if ($search) {
            $searchLower = mb_strtolower(trim($search));
            $jobsQuery->where(function ($q) use ($searchLower) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$searchLower}%"])
                  ->orWhereRaw('LOWER(location) LIKE ?', ["%{$searchLower}%"])
                  ->orWhereRaw('LOWER(employment_type) LIKE ?', ["%{$searchLower}%"])
                  ->orWhereHas('company', function ($cq) use ($searchLower) {
                      $cq->whereRaw('LOWER(name) LIKE ?', ["%{$searchLower}%"]);
                  })
                  ->orWhereHas('department', function ($dq) use ($searchLower) {
                      $dq->whereRaw('LOWER(name) LIKE ?', ["%{$searchLower}%"]);
                  })
                  ->orWhereHas('position', function ($pq) use ($searchLower) {
                      $pq->whereRaw('LOWER(name) LIKE ?', ["%{$searchLower}%"]);
                  });
            });
        }

        // 2. Filter Lokasi
        if ($location) {
            $jobsQuery->where('location', 'like', "%{$location}%");
        }

        // 3. Filter Departemen (ID atau Nama)
        if ($departmentId) {
            $jobsQuery->where('department_id', $departmentId);
        } elseif ($departmentName) {
            $jobsQuery->whereHas('department', function ($dq) use ($departmentName) {
                $dq->where('name', 'like', "%{$departmentName}%");
            });
        }

        // 4. Filter Perusahaan
        if ($companyId) {
            $jobsQuery->where('company_id', $companyId);
        }

        // 5. Filter Tipe Pekerjaan
        if ($employmentType) {
            $jobsQuery->where(function ($q) use ($employmentType) {
                if (in_array(strtolower($employmentType), ['magang', 'internship'])) {
                    $q->whereIn('employment_type', ['Magang', 'Internship']);
                } elseif (in_array(strtolower($employmentType), ['full time', 'full-time'])) {
                    $q->whereIn('employment_type', ['Full Time', 'Full-time']);
                } elseif (in_array(strtolower($employmentType), ['part time', 'part-time'])) {
                    $q->whereIn('employment_type', ['Part Time', 'Part-time']);
                } elseif (in_array(strtolower($employmentType), ['kontrak', 'contract'])) {
                    $q->whereIn('employment_type', ['Kontrak', 'Contract']);
                } else {
                    $q->where('employment_type', $employmentType);
                }
            });
        }

        // Sorting terbaru berdasarkan ID
        $paginated = $jobsQuery->latest('id')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => JobResource::collection($paginated->items()),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'per_page' => $paginated->perPage(),
                'total_items' => $paginated->total(),
                'total_pages' => $paginated->lastPage(),
                'has_next' => $paginated->hasMorePages(),
                'has_prev' => $paginated->currentPage() > 1,
            ],
            'links' => [
                'first' => $paginated->url(1),
                'last' => $paginated->url($paginated->lastPage()),
                'prev' => $paginated->previousPageUrl(),
                'next' => $paginated->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Display the specified open job detail.
     */
    public function show(string $id): JsonResponse
    {
        $job = Job::active()
            ->with(['company', 'department', 'position', 'degrees', 'majors'])
            ->find($id);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Lowongan pekerjaan tidak ditemukan atau sudah ditutup.',
            ], 404);
        }

        // Ambil lowongan terkait di departemen atau perusahaan yang sama
        $relatedJobs = Job::active()
            ->with(['company', 'department', 'position'])
            ->where('id', '!=', $id)
            ->where(function ($q) use ($job) {
                $q->where('department_id', $job->department_id)
                  ->orWhere('company_id', $job->company_id);
            })
            ->latest('id')
            ->take(3)
            ->get();

        return response()->json([
            'success' => true,
            'data' => new JobResource($job),
            'related_jobs' => JobResource::collection($relatedJobs),
        ]);
    }

    /**
     * List departments with active jobs count for frontend filter options.
     */
    public function departments(): JsonResponse
    {
        $departments = Department::withCount(['jobs' => fn($q) => $q->active()])
            ->having('jobs_count', '>', 0)
            ->get(['id', 'name']);

        return response()->json([
            'success' => true,
            'data' => $departments,
        ]);
    }
}

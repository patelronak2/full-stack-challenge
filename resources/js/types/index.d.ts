export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export interface Company {
    id: string;
    name: string;
    description: string;
    jobs?: Job[],
    jobs_count?: number
}

export interface Job {
    id: string;
    title: string;
    description: string;
    location?: string;
    position_type: string;
    salary_min: number;
    salary_max: number;
    created_at: string;
    company: Company;
    company_id?: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    flash: {
        success?: string
        error?: string
    };
};

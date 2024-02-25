import AuthenticatedUserLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function Index({ auth, plans }) {
    console.log(plans);
    return (
        <AuthenticatedUserLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Plans
                </h2>
            }
        >
            <Head title="Plans" />

            {plans.map((plan, index) => {
                return (
                    <div key={index} className="py-12">
                        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div className="p-6 text-gray-900">
                                    {plan.name} - {plan.price} - 
                                    {plan.description}
                                </div>
                            </div>
                        </div>
                    </div>
                );
            })}
        </AuthenticatedUserLayout>
    );
}

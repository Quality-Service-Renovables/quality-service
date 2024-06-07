import { toast } from "vue-sonner";

function handleErrors(data) {
    if (data.response) {
        // Si hay una respuesta de error, puedes acceder a los datos así:
        const responseData = data.response.data;

        // Verificamos si el error contiene un mensaje
        if (
            responseData &&
            responseData.status === "fail" &&
            responseData.message
        ) {
            // Iteramos sobre cada campo que contiene errores y mostramos los mensajes
            for (const field in responseData.message) {
                console.log(responseData.message[field]);
                const errors = responseData.message[field];
                // Aquí puedes manejar los errores como desees
                setTimeout(() => {
                    toast.error(`Errores en el campo ${field}:`, {
                        description: `${errors.join(", ")}`,
                    });
                }, 100);
            }
        } else {
            setTimeout(() => toast.error(`Algo salió mal, por favor intenta de nuevo o comunicate con TI.`), 100);
        }
    } else {
        setTimeout(() => toast.error(`Algo salió mal, por favor intenta de nuevo o comunicate con TI.`), 100);
    }
}

function hasPermissionTo(permission) {
    return this.$page.props.auth.permissions.includes(permission);
}

export default {
    methods: {
        handleErrors,
        hasPermissionTo,
    },
};

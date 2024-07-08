import { toast } from "vue-sonner";
import { useDisplay } from "vuetify";

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
                }, 500);
            }
        } else {
            setTimeout(
                () =>
                    toast.error(
                        `Algo salió mal, por favor intenta de nuevo o comunicate con TI.`
                    ),
                100
            );
        }
    } else {
        setTimeout(
            () =>
                toast.error(
                    `Algo salió mal, por favor intenta de nuevo o comunicate con TI.`
                ),
            100
        );
    }
}

function hasPermissionTo(permission) {
    return this.$page.props.auth.permissions.includes(permission);
}

function isMobile() {
    let mobile = false;
    const display = useDisplay();
    const updateMobile = () => {
        mobile = display.mobile.value;
    };
    updateMobile();
    window.addEventListener("resize", updateMobile);
    this.removeResizeListener = () =>
        window.removeEventListener("resize", updateMobile);
    return mobile;
}

export default {
    methods: {
        handleErrors,
        hasPermissionTo,
        isMobile,
    },
};

/** @type {import('tailwindcss').Config} */
module.exports = {
	// darkMode: ["class", "media"],
	// darkMode: "media",
	darkMode: "class",
	// content: ["./**/*.php"],
	content: [
		"./includes/Core/*.php",
		"./includes/Hooks/*.php",
		"./includes/Hooks/*.php",
		"./template/**/*.php",
		"./woocommerce/**/*.php",
		"./*.php",
	],
	theme: {
		fontSize: {
			"2xs": ["0.75rem", { lineHeight: "1.25rem" }],
			xs: ["0.8125rem", { lineHeight: "1.5rem" }],
			sm: ["0.875rem", { lineHeight: "1.5rem" }],
			base: ["1rem", { lineHeight: "1.75rem" }],
			lg: ["1.125rem", { lineHeight: "1.75rem" }],
			xl: ["1.25rem", { lineHeight: "1.75rem" }],
			"2xl": ["1.5rem", { lineHeight: "2rem" }],
			"3xl": ["1.875rem", { lineHeight: "2.25rem" }],
			"4xl": ["2.25rem", { lineHeight: "2.5rem" }],
			"5xl": ["3rem", { lineHeight: "1" }],
			"6xl": ["3.75rem", { lineHeight: "1" }],
			"7xl": ["4.5rem", { lineHeight: "1" }],
			"8xl": ["6rem", { lineHeight: "1" }],
			"9xl": ["8rem", { lineHeight: "1" }],
		},
		typography: require("./typography"),
		extend: {
			backgroundImage: {
				"gradient-radial": "radial-gradient(var(--tw-gradient-stops))",
				"gradient-conic":
					"conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))",
			},
			gridTemplateColumns: {
				fluid: "repeat(auto-fit, minmax(15rem, 1fr))",
				"[auto,auto,1fr]": "auto auto 1fr",
			},
			boxShadow: {
				glow: "0 0 4px rgb(0 0 0 / 0.1)",
			},
			maxWidth: {
				lg: "33rem",
				"2xl": "40rem",
				"3xl": "50rem",
				"5xl": "66rem",
			},
			opacity: {
				1: "0.01",
				2.5: "0.025",
				7.5: "0.075",
				15: "0.15",
			},
			screens: {
				xs: "425px",
				sm: "640px",
				md: "768px",
				lg: "1024px",
				xl: "1280px",
				"2xl": "1536px",
			},
			container: {
				center: true,
				padding: {
					DEFAULT: "1rem",
					sm: "2rem",
					lg: "2rem",
					xl: "2rem",
					"2xl": "2rem",
				},
				screens: {
					"2xl": "1400px",
				},
			},
			colors: {
				border: "hsl(var(--border))",
				input: "hsl(var(--input))",
				ring: "hsl(var(--ring))",
				background: "var(--background)",
				foreground: "hsl(var(--foreground))",
				dark: "#0b100b",
				primary: {
					DEFAULT: "hsl(var(--primary))",
					foreground: "hsl(var(--primary-foreground))",
					// 50: "#d2e0d3",
					// 100: "#c2d6c4",
					// 200: "#b6ceb7",
					// 300: "#a5bea6",
					// 400: "#a1bba2",
					// 500: "#92B193",
					// 600: "#7E9F82",
					// 700: "#6A8D72",
					// 800: "#568B61",
					// 900: "#407950",
					50: "#fef2f2",
					100: "#fee2e2",
					200: "#fecaca",
					300: "#fca5a5",
					400: "#f87171",
					500: "#ef4444",
					600: "#dc2626",
					700: "#b91c1c",
					800: "#991b1b",
					900: "#7f1d1d",
					950: "#450a0a",
				},

				secondary: {
					DEFAULT: "hsl(var(--secondary))",
					foreground: "hsl(var(--secondary-foreground))",
				},
				destructive: {
					DEFAULT: "hsl(var(--destructive))",
					foreground: "hsl(var(--destructive-foreground))",
				},
				muted: {
					DEFAULT: "hsl(var(--muted))",
					foreground: "hsl(var(--muted-foreground))",
				},
				accent: {
					DEFAULT: "hsl(var(--accent))",
					foreground: "hsl(var(--accent-foreground))",
				},
				popover: {
					DEFAULT: "hsl(var(--popover))",
					foreground: "hsl(var(--popover-foreground))",
				},
				card: {
					DEFAULT: "hsl(var(--card))",
					foreground: "hsl(var(--card-foreground))",
				},
			},
			borderRadius: {
				lg: "var(--radius)",
				md: "calc(var(--radius) - 2px)",
				sm: "calc(var(--radius) - 4px)",
			},
			keyframes: {
				"accordion-down": {
					from: { height: 0 },
					to: { height: "var(--radix-accordion-content-height)" },
				},
				"accordion-up": {
					from: { height: "var(--radix-accordion-content-height)" },
					to: { height: 0 },
				},
			},
			animation: {
				"accordion-down": "accordion-down 0.2s ease-out",
				"accordion-up": "accordion-up 0.2s ease-out",
			},
			transitionTimingFunction: {
				"out-flex": "cubic-bezier(0.05, 0.6, 0.4, 0.9)",
			},
		},
	},
	variants: {
		extend: {
			visibility: ["group-hover"],
			display: ["group-hover"],
		},
	},
	plugins: [
		require("@tailwindcss/typography"),
		require("@tailwindcss/aspect-ratio"),
		require("@tailwindcss/forms"),
		require("tailwindcss-animate"),
		require("@tailwindcss/forms"),
		require("@tailwindcss/aspect-ratio"),
	],
};

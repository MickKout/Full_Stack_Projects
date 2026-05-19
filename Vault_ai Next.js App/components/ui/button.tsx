import * as React from 'react';
import clsx from 'clsx';

export interface ButtonProps extends React.ButtonHTMLAttributes<HTMLButtonElement> {
  variant?: 'default' | 'secondary' | 'ghost';
  size?: 'default' | 'sm';
}

const variantClasses: Record<NonNullable<ButtonProps['variant']>, string> = {
  default: 'bg-indigo-600 text-white hover:bg-indigo-500',
  secondary: 'bg-white text-slate-900 border border-slate-200 hover:bg-slate-100',
  ghost: 'bg-transparent text-slate-200 hover:bg-slate-100',
};

const sizeClasses: Record<NonNullable<ButtonProps['size']>, string> = {
  default: 'h-11 px-5',
  sm: 'h-9 px-4 text-sm',
};

const Button = React.forwardRef<HTMLButtonElement, ButtonProps>(
  ({ className, variant = 'default', size = 'default', ...props }, ref) => (
    <button
      ref={ref}
      className={clsx(
        'inline-flex items-center justify-center rounded-full text-sm font-semibold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none',
        variantClasses[variant],
        sizeClasses[size],
        className
      )}
      {...props}
    />
  )
);
Button.displayName = 'Button';

export { Button };
